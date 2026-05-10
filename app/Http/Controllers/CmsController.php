<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\Lead;use App\Models\LeadNote;use App\Models\Booking;
use App\Models\Fleet;use App\Models\Route;use App\Models\Package;
use App\Models\BlogPost;use App\Models\Testimonial;use App\Models\Faq;
use App\Models\TimelineItem;use App\Models\PageSection;use App\Models\Setting;
use Illuminate\Support\Facades\Cache;use Illuminate\Support\Facades\Storage;

class CmsController extends Controller
{
    private function checkAuth(){if(!session('cms_admin'))return redirect()->route('cms.login');return null;}

    // ═══ AUTH ════════════════════════════════════════════════════════════════
    public function loginForm(){if(session('cms_admin'))return redirect()->route('cms.dashboard');return view('cms.auth.login');}
public function loginPost(Request $request)
{
    $request->validate([
        'email'    => 'required|email',
        'password' => 'required|min:6',
    ]);

    $admin = \App\Models\AdminUser::where('email', $request->email)
                                  ->where('is_active', true)
                                  ->first();

    if (!$admin || !\Hash::check($request->password, $admin->password)) {
        return back()
            ->withErrors(['email' => 'Invalid email or password.'])
            ->withInput();
    }

    // Update last login
    $admin->update(['last_login_at' => now()]);

    session(['cms_admin' => [
        'id'    => $admin->id,
        'name'  => $admin->name,
        'email' => $admin->email,
    ]]);

    return redirect()->route('cms.dashboard')
                     ->with('success', 'Welcome back, ' . $admin->name . '!');
}
public function logout(){session()->forget('cms_admin');return redirect()->route('cms.login');}

    // ═══ DASHBOARD ═══════════════════════════════════════════════════════════
    public function dashboard(){
        if($r=$this->checkAuth())return $r;
        $stats=['total_leads'=>Lead::thisMonth()->count(),'new_today'=>Lead::today()->count(),'new_leads'=>Lead::newLeads()->count(),'confirmed'=>Lead::byStatus('confirmed')->thisMonth()->count(),'completed'=>Lead::byStatus('completed')->thisMonth()->count(),'cancelled'=>Lead::byStatus('cancelled')->thisMonth()->count(),'revenue'=>Booking::thisMonth()->whereIn('status',['confirmed','completed'])->sum('total_fare')];
        $pipeline=collect([['label'=>'New','color'=>'#3B82F6','status'=>'new'],['label'=>'Contacted','color'=>'#F59E0B','status'=>'contacted'],['label'=>'Quoted','color'=>'#EAB308','status'=>'quoted'],['label'=>'Confirmed','color'=>'#10B981','status'=>'confirmed'],['label'=>'Completed','color'=>'#083C5D','status'=>'completed']])->map(function($stage){$stage['leads']=Lead::byStatus($stage['status'])->latest()->take(5)->get()->map(fn($l)=>['id'=>$l->id,'name'=>$l->name,'from_city'=>$l->from_city,'to_city'=>$l->to_city,'phone'=>$l->phone,'time_ago'=>$l->time_ago])->all();return $stage;})->all();
        $recentLeads=Lead::latest()->take(8)->get()->map(fn($l)=>['id'=>$l->id,'name'=>$l->name,'phone'=>$l->phone,'from_city'=>$l->from_city,'to_city'=>$l->to_city,'car_type'=>$l->car_type,'status'=>$l->status,'estimated_fare'=>$l->estimated_fare,'time_ago'=>$l->time_ago,'travel_date'=>$l->travel_date])->all();
        $activity=Lead::latest()->take(3)->get()->map(fn($l)=>['type'=>'lead','icon'=>'📋','title'=>'New lead — '.$l->name,'meta'=>$l->from_city.' → '.$l->to_city,'time'=>$l->time_ago,'ts'=>$l->created_at])->concat(Booking::latest()->take(2)->get()->map(fn($b)=>['type'=>'booking','icon'=>'✅','title'=>'Booking '.$b->booking_ref,'meta'=>$b->from_city.' → '.$b->to_city,'time'=>$b->created_at->diffForHumans(),'ts'=>$b->created_at]))->sortByDesc('ts')->take(6)->values()->all();
        return view('cms.dashboard.index',compact('stats','pipeline','recentLeads','activity'));
    }

    // ═══ HOMEPAGE EDITOR ═════════════════════════════════════════════════════
    public function homepageEditor(){
        if($r=$this->checkAuth())return $r;
        $sections=PageSection::where('page','homepage')->orderBy('section')->orderBy('sort_order')->get()->groupBy('section')->map(fn($items)=>$items->pluck('value','key')->toArray());
        return view('cms.content.homepage',compact('sections'));
    }
    public function homepageUpdate(Request $request){
        if($r=$this->checkAuth())return $r;
        foreach($request->except('_token','_method') as $fk=>$v){
            if(!str_contains($fk,'__'))continue;
            if($v===null||trim((string)$v)==='')continue;
            [$sec,$key]=explode('__',$fk,2);
            PageSection::setValue('homepage',$sec,$key,$v);
        }
        PageSection::clearPageCache('homepage');
        return back()->with('success','Homepage updated!');
    }

    // ═══ LEADS ═══════════════════════════════════════════════════════════════
    public function leads(Request $request){
        if($r=$this->checkAuth())return $r;
        $currentStatus=$request->get('status','all');$search=$request->get('search','');$page=(int)$request->get('page',1);$limit=20;
        $q=Lead::latest();
        if($currentStatus!=='all')$q->where('status',$currentStatus);
        if($search)$q->where(fn($q)=>$q->where('name','like',"%{$search}%")->orWhere('phone','like',"%{$search}%")->orWhere('from_city','like',"%{$search}%")->orWhere('to_city','like',"%{$search}%"));
        $total=$q->count();$totalPages=max(1,ceil($total/$limit));
        $leads=$q->skip(($page-1)*$limit)->take($limit)->get()->map(fn($l)=>['id'=>$l->id,'name'=>$l->name,'phone'=>$l->phone,'from_city'=>$l->from_city,'to_city'=>$l->to_city,'car_type'=>$l->car_type,'status'=>$l->status,'source'=>$l->source,'travel_date'=>$l->travel_date?->format('Y-m-d'),'estimated_fare'=>$l->estimated_fare,'time_ago'=>$l->time_ago])->all();
        return view('cms.leads.index',compact('leads','total','totalPages','page','currentStatus','search'));
    }
    public function leadShow(int $id){
        if($r=$this->checkAuth())return $r;
        $l=Lead::with('notes')->findOrFail($id);
        $lead=['id'=>$l->id,'name'=>$l->name,'phone'=>$l->phone,'from_city'=>$l->from_city,'to_city'=>$l->to_city,'car_type'=>$l->car_type,'car_label'=>$l->car_label,'trip_type'=>$l->trip_type,'travel_date'=>$l->travel_date?->format('Y-m-d'),'passengers'=>$l->passengers,'message'=>$l->message,'status'=>$l->status,'source'=>$l->source,'estimated_fare'=>$l->estimated_fare,'follow_up_at'=>$l->follow_up_at?->format('Y-m-d\TH:i'),'time_ago'=>$l->time_ago,'notes'=>$l->notes->map(fn($n)=>['text'=>$n->note,'author'=>$n->author,'time'=>$n->created_at->diffForHumans()])->all()];
        return view('cms.leads.show',compact('lead'));
    }
    public function leadUpdate(Request $request,int $id){
        if($r=$this->checkAuth())return $r;
        $lead=Lead::findOrFail($id);
        $data=[];
        if($request->filled('status'))$data['status']=$request->status;
        if($request->has('estimated_fare'))$data['estimated_fare']=$request->estimated_fare;
        if($request->has('follow_up_at'))$data['follow_up_at']=$request->follow_up_at?:null;
        if(!empty($data))$lead->update($data);
        return back()->with('success','Lead updated.');
    }
    public function leadStatusUpdate(Request $request,int $id){
        if($r=$this->checkAuth())return $r;
        $l=Lead::findOrFail($id);$l->update(['status'=>$request->status]);
        return response()->json(['success'=>true,'status'=>$l->status]);
    }
    public function leadNote(Request $request,int $id){
        if($r=$this->checkAuth())return $r;
        $request->validate(['note'=>'required|string|max:1000']);
        LeadNote::create(['lead_id'=>$id,'note'=>$request->note,'author'=>session('cms_admin.name','RK Shah')]);
        return back()->with('success','Note added.');
    }

    // ═══ BOOKINGS ════════════════════════════════════════════════════════════
    public function bookings(Request $request){
        if($r=$this->checkAuth())return $r;
        $status=$request->get('status','all');$q=Booking::orderBy('travel_date','desc');
        if($status!=='all')$q->where('status',$status);
        $bookings=$q->get()->map(fn($b)=>['id'=>$b->id,'ref'=>$b->booking_ref,'name'=>$b->customer_name,'phone'=>$b->customer_phone,'from'=>$b->from_city,'to'=>$b->to_city,'travel_date'=>$b->travel_date?->format('d M Y'),'car'=>$b->car_label,'driver'=>$b->driver_name,'fare'=>$b->total_fare,'advance'=>$b->advance_paid,'status'=>$b->status,'trip_type'=>$b->trip_type])->all();
        return view('cms.bookings.index',compact('bookings','status'));
    }
    public function bookingShow(int $id){
        if($r=$this->checkAuth())return $r;
        $b=Booking::findOrFail($id);
        $booking=['id'=>$b->id,'ref'=>$b->booking_ref,'name'=>$b->customer_name,'phone'=>$b->customer_phone,'from'=>$b->from_city,'to'=>$b->to_city,'travel_date'=>$b->travel_date?->format('d M Y'),'pickup_time'=>$b->pickup_time,'car'=>$b->car_label,'driver'=>$b->driver_name,'driver_phone'=>$b->driver_phone,'passengers'=>$b->passengers,'trip_type'=>$b->trip_type_label,'fare'=>$b->total_fare,'advance'=>$b->advance_paid,'advance_method'=>$b->advance_method,'status'=>$b->status,'notes'=>$b->notes];
        return view('cms.bookings.show',compact('booking'));
    }
    public function bookingCreate(Request $request){
        if($r=$this->checkAuth())return $r;
        $lead=$request->lead_id?Lead::find($request->lead_id):null;
        $cars=Fleet::active()->ordered()->get();
        return view('cms.bookings.create',compact('lead','cars'));
    }
    public function bookingStore(Request $request){
        if($r=$this->checkAuth())return $r;
        $request->validate(['customer_name'=>'required','customer_phone'=>'required','from_city'=>'required','to_city'=>'required','travel_date'=>'required|date','total_fare'=>'required|numeric','car_type'=>'required']);
        $booking=Booking::create(['customer_name'=>$request->customer_name,'customer_phone'=>preg_replace('/\D/','',$request->customer_phone),'from_city'=>$request->from_city,'to_city'=>$request->to_city,'travel_date'=>$request->travel_date,'pickup_time'=>$request->pickup_time,'car_type'=>$request->car_type,'driver_name'=>$request->driver_name,'driver_phone'=>$request->driver_phone,'trip_type'=>$request->trip_type??'one_way','passengers'=>$request->passengers,'total_fare'=>$request->total_fare,'advance_paid'=>$request->advance_paid??0,'advance_method'=>$request->advance_method,'status'=>'confirmed','notes'=>$request->notes,'lead_id'=>$request->lead_id]);
        if($request->lead_id)Lead::where('id',$request->lead_id)->update(['status'=>'confirmed']);
        return redirect()->route('cms.bookings')->with('success','Booking '.$booking->booking_ref.' created!');
    }
    public function bookingUpdate(Request $request,int $id){
        if($r=$this->checkAuth())return $r;
        $b=Booking::findOrFail($id);$data=[];
        if($request->filled('status'))$data['status']=$request->status;
        if($request->filled('driver_name'))$data['driver_name']=$request->driver_name;
        if($request->filled('driver_phone'))$data['driver_phone']=$request->driver_phone;
        if($request->filled('notes'))$data['notes']=$request->notes;
        if($request->has('advance_paid'))$data['advance_paid']=$request->advance_paid;
        if(!empty($data))$b->update($data);
        return back()->with('success','Booking updated.');
    }
    public function calendar(Request $request){
        if($r=$this->checkAuth())return $r;
        $currentMonth=$request->get('month',date('Y-m'));$dt=\DateTime::createFromFormat('Y-m',$currentMonth);
        $daysInMonth=(int)$dt->format('t');$startOffset=(int)$dt->format('N')-1;
        $prevMonth=(clone $dt)->modify('-1 month')->format('Y-m');$nextMonth=(clone $dt)->modify('+1 month')->format('Y-m');
        $bookings=Booking::whereYear('travel_date',$dt->format('Y'))->whereMonth('travel_date',$dt->format('m'))->whereNotIn('status',['cancelled'])->get();
        $calendar=[];foreach($bookings as $b){$day=(int)$b->travel_date->format('j');$type=match($b->trip_type){'airport'=>'airport','hourly'=>'local',default=>'outstation'};$calendar[$day][]=['type'=>$type,'label'=>$b->from_city.' — '.$b->customer_name];}
        return view('cms.bookings.calendar',compact('currentMonth','daysInMonth','startOffset','prevMonth','nextMonth','calendar'));
    }

    // ═══ FLEET ═══════════════════════════════════════════════════════════════
    public function fleet(){
        if($r=$this->checkAuth())return $r;
        $cars=Fleet::ordered()->get()->map(function($car){
            $car->utilisation=min(100,Booking::where('car_type',str_replace('-','_',$car->slug))->thisMonth()->count()*10);
            return $car;
        });
        return view('cms.fleet.index',compact('cars'));
    }
    public function fleetStore(Request $request){
        if($r=$this->checkAuth())return $r;
        $request->validate(['name'=>'required|string|max:100','type'=>'required|string|max:60','fuel'=>'required|string|max:30','seats'=>'required|integer|min:1|max:20','rate_per_km'=>'required|numeric|min:1','car_image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:4096']);
        try {
            $slug=$base=\Str::slug($request->name);$i=1;
            while(Fleet::where('slug',$slug)->exists()){$slug=$base.'-'.$i++;}
            $imagePath=null;
            if($request->hasFile('car_image')){
                $imagePath=$request->file('car_image')->store('fleet','public');
                if(!$imagePath) return back()->withInput()->with('error','Image upload failed. Please try again or use a smaller file.');
            }
            Fleet::create(['name'=>$request->name,'slug'=>$slug,'type'=>$request->type,'fuel'=>$request->fuel,'model_year'=>$request->model_year??date('Y'),'seats'=>$request->seats,'luggage'=>$request->luggage,'rate_per_km'=>$request->rate_per_km,'driver_allowance'=>$request->driver_allowance??0,'min_km'=>$request->min_km??250,'badge'=>$request->badge,'emoji'=>$request->emoji??'🚗','bg_class'=>$request->bg_class??'fleet-dzire','featured_image'=>$imagePath,'features'=>array_values(array_filter(array_map('trim',explode(',',$request->features??'')))),'best_for'=>$request->best_for,'description'=>$request->description,'is_active'=>true,'sort_order'=>(Fleet::min('sort_order') ?? 1) - 1]);
            Cache::forget('fare_settings');
            return back()->with('success',$request->name.' added to fleet!');
        } catch(\Exception $e) {
            \Log::error('fleetStore failed: '.$e->getMessage());
            return back()->withInput()->with('error','Failed to add car: '.$e->getMessage());
        }
    }
    public function fleetUpdate(Request $request,int $id){
        if($r=$this->checkAuth())return $r;
        try {
            $car=Fleet::findOrFail($id);$data=[];
            if($request->filled('name'))           $data['name']            =$request->name;
            if($request->filled('type'))            $data['type']            =$request->type;
            if($request->filled('fuel'))            $data['fuel']            =$request->fuel;
            if($request->filled('seats'))           $data['seats']           =$request->seats;
            if($request->filled('model_year'))      $data['model_year']      =$request->model_year;
            if($request->filled('luggage'))         $data['luggage']         =$request->luggage;
            if($request->filled('rate_per_km'))     $data['rate_per_km']     =$request->rate_per_km;
            if($request->filled('driver_allowance'))$data['driver_allowance']=$request->driver_allowance;
            if($request->has('badge'))              $data['badge']           =$request->badge;
            if($request->filled('best_for'))        $data['best_for']        =$request->best_for;
            if($request->filled('emoji'))           $data['emoji']           =$request->emoji;
            if($request->filled('bg_class'))        $data['bg_class']        =$request->bg_class;
            if($request->filled('min_km'))          $data['min_km']          =$request->min_km;
            if($request->filled('features')){$data['features']=array_values(array_filter(array_map('trim',explode(',',$request->features))));}
            if($request->has('is_active_submitted')){$data['is_active']=$request->boolean('is_active');}
            if($request->hasFile('car_image')){
                $request->validate(['car_image'=>'image|mimes:jpg,jpeg,png,webp|max:4096']);
                $path=$request->file('car_image')->store('fleet','public');
                if(!$path) return back()->with('error','Image upload failed. Check file size (max 4MB) and format (jpg/png/webp).');
                if($car->featured_image)Storage::disk('public')->delete($car->featured_image);
                $data['featured_image']=$path;
            }
            if(!empty($data))$car->update($data);
            Cache::forget('fare_settings');
            return back()->with('success',$car->name.' updated successfully.');
        } catch(\Exception $e){
            \Log::error('fleetUpdate #'.$id.' failed: '.$e->getMessage());
            return back()->with('error','Update failed: '.$e->getMessage());
        }
    }
    public function fleetDelete(int $id){
        if($r=$this->checkAuth())return $r;
        $car=Fleet::findOrFail($id);$name=$car->name;
        if($car->featured_image)Storage::disk('public')->delete($car->featured_image);
        $car->delete();Cache::forget('fare_settings');
        return back()->with('success',$name.' removed from fleet.');
    }

    // ═══ ROUTES ══════════════════════════════════════════════════════════════
    public function routes(){
        if($r=$this->checkAuth())return $r;
        $routes=Route::orderBy('sort_order')->get();
        return view('cms.routes.index',compact('routes'));
    }
    public function routeStore(Request $request){
        if($r=$this->checkAuth())return $r;
        $request->validate(['from_city'=>'required|string|max:80','to_city'=>'required|string|max:80','distance_km'=>'required|integer|min:0','route_image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:4096']);
        try {
            $slug=$base=\Str::slug($request->from_city.'-to-'.$request->to_city);$i=1;
            while(Route::where('slug',$slug)->exists()){$slug=$base.'-'.$i++;}
            $imagePath=null;
            if($request->hasFile('route_image')){
                $imagePath=$request->file('route_image')->store('routes','public');
                if(!$imagePath) return back()->withInput()->with('error','Image upload failed. Please try a smaller file (max 4MB).');
            }
            Route::create(['from_city'=>$request->from_city,'to_city'=>$request->to_city,'slug'=>$slug,'distance_km'=>$request->distance_km,'duration_hrs'=>$request->duration_hrs?:null,'highway'=>$request->highway,'highlight'=>$request->highlight,'tag'=>$request->tag,'accent_color'=>$request->accent_color??'#083C5D','price_dzire'=>$request->price_dzire?:null,'price_ertiga'=>$request->price_ertiga?:null,'price_creta'=>$request->price_creta?:null,'price_innova'=>$request->price_innova?:null,'featured_image'=>$imagePath,'is_published'=>$request->boolean('is_published',true),'sort_order'=>(Route::min('sort_order') ?? 1) - 1]);
            return back()->with('success',$request->from_city.' → '.$request->to_city.' added!');
        } catch(\Exception $e){
            \Log::error('routeStore failed: '.$e->getMessage());
            return back()->withInput()->with('error','Failed to add route: '.$e->getMessage());
        }
    }
    public function routeUpdate(Request $request,int $id){
        if($r=$this->checkAuth())return $r;
        try {
            $route=Route::findOrFail($id);$data=[];
            foreach(['price_dzire','price_ertiga','price_creta','price_innova'] as $field){if($request->exists($field))$data[$field]=$request->input($field)?:null;}
            if($request->exists('is_published'))$data['is_published']=$request->has('is_published');
            foreach(['from_city','to_city','distance_km','duration_hrs','highway','highlight','tag','accent_color'] as $field){if($request->filled($field))$data[$field]=$request->input($field);}
            if($request->hasFile('route_image')){
                $request->validate(['route_image'=>'image|mimes:jpg,jpeg,png,webp|max:4096']);
                $path=$request->file('route_image')->store('routes','public');
                if(!$path) return back()->with('error','Image upload failed. Check file size (max 4MB) and format.');
                if($route->featured_image)Storage::disk('public')->delete($route->featured_image);
                $data['featured_image']=$path;
            }
            if(!empty($data))$route->update($data);
            Cache::forget('route_fare_'.strtolower($route->to_city));
            return back()->with('success','Route updated successfully.');
        } catch(\Exception $e){
            \Log::error('routeUpdate #'.$id.' failed: '.$e->getMessage());
            return back()->with('error','Update failed: '.$e->getMessage());
        }
    }
    public function routeToggle(Request $request,string $slug){
        if($r=$this->checkAuth())return $r;
        $route=Route::where('slug',$slug)->firstOrFail();
        $route->update(['is_published'=>$request->boolean('is_published')]);
        return response()->json(['success'=>true,'is_published'=>$route->is_published]);
    }
    public function routeDelete(int $id){
        if($r=$this->checkAuth())return $r;
        $route=Route::findOrFail($id);$name=$route->from_city.' → '.$route->to_city;
        if($route->featured_image)Storage::disk('public')->delete($route->featured_image);
        Cache::forget('route_fare_'.strtolower($route->to_city));
        $route->delete();
        return back()->with('success','Route "'.$name.'" deleted.');
    }

    // ═══ PACKAGES ════════════════════════════════════════════════════════════
    public function packages(){
        if($r=$this->checkAuth())return $r;
        $packages=Package::ordered()->get();
        return view('cms.content.packages',compact('packages'));
    }
    public function packageStore(Request $request){
        if($r=$this->checkAuth())return $r;
        $request->validate(['name'=>'required|string|max:150','nights'=>'required|integer|min:0','days'=>'required|integer|min:0','package_image'=>'nullable|image|mimes:jpg,jpeg,png,webp|max:4096']);
        try {
            $slug=$base=\Str::slug($request->name);$i=1;
            while(Package::where('slug',$slug)->exists()){$slug=$base.'-'.$i++;}
            $destinations=array_values(array_filter(array_map('trim',explode(',',$request->destinations??''))));
            $includes=array_values(array_filter(array_map('trim',explode(',',$request->includes??''))));
            $imagePath=null;
            if($request->hasFile('package_image')){
                $imagePath=$request->file('package_image')->store('packages','public');
                if(!$imagePath) return back()->withInput()->with('error','Image upload failed. Please try a smaller file (max 4MB).');
            }
            Package::create(['name'=>$request->name,'slug'=>$slug,'nights'=>$request->nights,'days'=>$request->days,'price'=>$request->price??0,'badge'=>$request->badge,'emoji'=>$request->emoji??'🎒','bg_class'=>$request->bg_class??'pkg-custom','destinations'=>$destinations,'includes'=>$includes?:['AC Cab','Expert Driver','Fuel & Tolls'],'description'=>$request->description,'itinerary'=>[],'featured_image'=>$imagePath,'is_published'=>$request->boolean('is_published',true),'sort_order'=>(Package::min('sort_order') ?? 1) - 1]);
            return back()->with('success',$request->name.' package added!');
        } catch(\Exception $e){
            \Log::error('packageStore failed: '.$e->getMessage());
            return back()->withInput()->with('error','Failed to add package: '.$e->getMessage());
        }
    }
    public function packageUpdate(Request $request,int $id){
        if($r=$this->checkAuth())return $r;
        try {
            $pkg=Package::findOrFail($id);$data=[];
            if($request->filled('name'))        $data['name']        =$request->name;
            if($request->filled('description')) $data['description'] =$request->description;
            if($request->has('badge'))          $data['badge']       =$request->badge;
            if($request->has('price'))          $data['price']       =$request->price;
            if($request->filled('emoji'))       $data['emoji']       =$request->emoji;
            if($request->filled('bg_class'))    $data['bg_class']    =$request->bg_class;
            if($request->filled('destinations')){$data['destinations']=array_values(array_filter(array_map('trim',explode(',',$request->destinations))));}
            if($request->filled('includes')){$data['includes']=array_values(array_filter(array_map('trim',explode(',',$request->includes))));}
            if($request->has('is_published_submitted')){$data['is_published']=$request->boolean('is_published');}
            if($request->hasFile('package_image')){
                $request->validate(['package_image'=>'image|mimes:jpg,jpeg,png,webp|max:4096']);
                $path=$request->file('package_image')->store('packages','public');
                if(!$path) return back()->with('error','Image upload failed. Check file size (max 4MB) and format.');
                if($pkg->featured_image)Storage::disk('public')->delete($pkg->featured_image);
                $data['featured_image']=$path;
            }
            if(!empty($data))$pkg->update($data);
            return back()->with('success',$pkg->name.' updated successfully.');
        } catch(\Exception $e){
            \Log::error('packageUpdate #'.$id.' failed: '.$e->getMessage());
            return back()->with('error','Update failed: '.$e->getMessage());
        }
    }
    public function packageDelete(int $id){
        if($r=$this->checkAuth())return $r;
        $pkg=Package::findOrFail($id);$name=$pkg->name;
        if($pkg->featured_image)Storage::disk('public')->delete($pkg->featured_image);
        $pkg->delete();
        return back()->with('success','"'.$name.'" deleted.');
    }

    // ═══ TESTIMONIALS ════════════════════════════════════════════════════════
    public function testimonials(){if($r=$this->checkAuth())return $r;$testimonials=Testimonial::orderBy('sort_order')->get();return view('cms.content.testimonials',compact('testimonials'));}
    public function testimonialStore(Request $request){
        if($r=$this->checkAuth())return $r;
        $request->validate(['customer_name'=>'required','review_text'=>'required','rating'=>'required|integer|min:1|max:5']);
        $name=$request->customer_name;$parts=explode(' ',$name);
        $initials=strtoupper(substr($parts[0],0,1).substr($parts[1]??'',0,1));
        Testimonial::create(['customer_name'=>$name,'initials'=>$initials,'rating'=>$request->rating,'review_text'=>$request->review_text,'trip_route'=>$request->trip_route,'car_used'=>$request->car_used,'source'=>$request->source??'Google Review','is_published'=>true,'sort_order'=>Testimonial::max('sort_order')+1]);
        return back()->with('success','Review added.');
    }
    public function testimonialUpdate(Request $request,int $id){if($r=$this->checkAuth())return $r;Testimonial::findOrFail($id)->update(['is_published'=>$request->boolean('is_published')]);return response()->json(['success'=>true]);}
    public function testimonialDelete(int $id){if($r=$this->checkAuth())return $r;Testimonial::findOrFail($id)->delete();return back()->with('success','Review deleted.');}

    // ═══ BLOG ════════════════════════════════════════════════════════════════
    public function blog(){if($r=$this->checkAuth())return $r;$posts=BlogPost::latest()->get();return view('cms.blog.index',compact('posts'));}
    public function blogCreate(){if($r=$this->checkAuth())return $r;return view('cms.blog.create');}
    public function blogStore(Request $request){
        if($r=$this->checkAuth())return $r;
        $request->validate(['title'=>'required|min:5','content'=>'required']);
        BlogPost::create(['title'=>$request->title,'slug'=>$request->slug?:\Str::slug($request->title),'category'=>$request->category,'excerpt'=>$request->excerpt,'content'=>$request->content,'emoji'=>$request->emoji??'✍️','bg_class'=>$request->bg_class??'blog-b1','seo_title'=>$request->seo_title,'seo_description'=>$request->seo_description,'status'=>$request->status??'draft','published_at'=>$request->status==='published'?now():null]);
        return redirect()->route('cms.blog')->with('success','Post saved!');
    }
    public function blogEdit(string $slug){if($r=$this->checkAuth())return $r;$post=BlogPost::where('slug',$slug)->firstOrFail();return view('cms.blog.create',compact('post'));}
    public function blogUpdate(Request $request,string $slug){
        if($r=$this->checkAuth())return $r;
        $post=BlogPost::where('slug',$slug)->firstOrFail();
        $post->update(['title'=>$request->title,'category'=>$request->category,'excerpt'=>$request->excerpt,'content'=>$request->content,'seo_title'=>$request->seo_title,'seo_description'=>$request->seo_description,'status'=>$request->status,'published_at'=>$request->status==='published'&&!$post->published_at?now():$post->published_at]);
        return redirect()->route('cms.blog')->with('success','Post updated!');
    }
    public function blogDelete(string $slug){if($r=$this->checkAuth())return $r;BlogPost::where('slug',$slug)->firstOrFail()->delete();return back()->with('success','Post deleted.');}

    // ═══ FAQS ════════════════════════════════════════════════════════════════
    public function faqs(){if($r=$this->checkAuth())return $r;$faqs=Faq::ordered()->get()->groupBy('category');return view('cms.content.faqs',compact('faqs'));}
    public function faqStore(Request $request){if($r=$this->checkAuth())return $r;$request->validate(['category'=>'required','question'=>'required','answer'=>'required']);Faq::create(['category'=>$request->category,'category_icon'=>$request->category_icon??'❓','question'=>$request->question,'answer'=>$request->answer,'is_published'=>true,'sort_order'=>Faq::max('sort_order')+1]);return back()->with('success','FAQ added.');}
    public function faqUpdate(Request $request,int $id){if($r=$this->checkAuth())return $r;$data=[];if($request->filled('question'))$data['question']=$request->question;if($request->filled('answer'))$data['answer']=$request->answer;if($request->has('is_published'))$data['is_published']=$request->boolean('is_published');Faq::findOrFail($id)->update($data);return back()->with('success','FAQ updated.');}
    public function faqDelete(int $id){if($r=$this->checkAuth())return $r;Faq::findOrFail($id)->delete();return back()->with('success','FAQ deleted.');}

    // ═══ ABOUT EDITOR ════════════════════════════════════════════════════════
    public function aboutEditor(){
        if($r=$this->checkAuth())return $r;
        $sections=PageSection::where('page','about')->orderBy('section')->orderBy('sort_order')->get()->groupBy('section')->map(fn($items)=>$items->pluck('value','key')->toArray());
        $timeline=TimelineItem::ordered()->get();
        $ownerPhoto=Setting::get('owner_photo','');
        return view('cms.content.about',compact('sections','timeline','ownerPhoto'));
    }
    public function aboutUpdate(Request $request){
        if($r=$this->checkAuth())return $r;
        foreach($request->except('_token','_method') as $fk=>$v){
            if(!str_contains($fk,'__'))continue;
            if($v===null||trim((string)$v)==='')continue;
            [$sec,$key]=explode('__',$fk,2);
            PageSection::setValue('about',$sec,$key,$v);
        }
        // Handle owner photo upload
        if($request->hasFile('owner_photo')){
            $request->validate(['owner_photo'=>'image|mimes:jpg,jpeg,png,webp|max:4096']);
            $old=Setting::get('owner_photo','');
            if($old)Storage::disk('public')->delete($old);
            $path=$request->file('owner_photo')->store('owner','public');
            Setting::set('owner_photo',$path);
        }
        PageSection::clearPageCache('about');
        Cache::forget('setting_owner_photo');
        return back()->with('success','About page updated!');
    }
    public function timelineStore(Request $request){
        if($r=$this->checkAuth())return $r;
        $request->validate(['year'=>'required','title'=>'required','description'=>'required']);
        TimelineItem::create(['year'=>$request->year,'title'=>$request->title,'description'=>$request->description,'icon'=>$request->icon??'📍','color'=>$request->color??'#D4A017','is_published'=>true,'sort_order'=>TimelineItem::max('sort_order')+1]);
        return back()->with('success','Milestone added.');
    }
    public function timelineDelete(int $id){if($r=$this->checkAuth())return $r;TimelineItem::findOrFail($id)->delete();return back()->with('success','Milestone deleted.');}

    // ═══ SETTINGS ════════════════════════════════════════════════════════════
    public function settings(){
        if($r=$this->checkAuth())return $r;
        $allSettings=Setting::all()->keyBy('key');
        return view('cms.settings.index',['settings'=>$allSettings->map(fn($s)=>$s->value)->toArray()]);
    }
    public function settingsUpdate(Request $request){
        if($r=$this->checkAuth())return $r;
        foreach($request->except('_token','_method','tab') as $key=>$value){
            if($value===null||trim((string)$value)==='')continue;
          Setting::set($key,$value);
       }
       Setting::clearCache();Cache::forget('fare_settings');Cache::forget('settings_public');
       return back()->with('success','Settings saved! Website updated instantly.');
   }

public function changePassword(Request $request)
{
    if ($r = $this->checkAuth()) return $r;

    $request->validate([
        'current_password' => 'required',
        'new_password'     => 'required|min:8|confirmed',
    ]);

    $admin = \App\Models\AdminUser::find(session('cms_admin.id'));

    if (!$admin || !\Hash::check($request->current_password, $admin->password)) {
        return back()->with('error', 'Current password is incorrect.');
    }

    $admin->update(['password' => \Hash::make($request->new_password)]);

    return back()->with('success', 'Password changed successfully!');
}

    // ═══ MEDIA ═══════════════════════════════════════════════════════════════
    public function media(){
        if($r=$this->checkAuth())return $r;

        // All folders that can have images
        $folders = ['media'=>'General','fleet'=>'Fleet','routes'=>'Routes','packages'=>'Packages','owner'=>'Owner'];
        $media   = [];

        foreach($folders as $folder=>$label){
            $path=storage_path('app/public/'.$folder);
            if(!is_dir($path)) mkdir($path,0755,true);

            $files=glob($path.'/*.{jpg,jpeg,png,webp,gif,JPG,JPEG,PNG,WEBP}',GLOB_BRACE) ?: [];
            foreach($files as $file){
                $name=basename($file);
                $media[]=[
                    'name'     => $name,
                    'folder'   => $folder,
                    'label'    => $label,
                    'url'      => asset('storage/'.$folder.'/'.$name),
                    'path'     => $folder.'/'.$name,
                    'size'     => round(filesize($file)/1024),
                    'modified' => filemtime($file),
                ];
            }
        }

        // Sort newest first
        usort($media, fn($a,$b) => $b['modified'] - $a['modified']);

        $totalSize = array_sum(array_column($media,'size'));

        return view('cms.media.index', compact('media','totalSize'));
    }
    public function mediaUpload(Request $request){
        if($r=$this->checkAuth())return $r;
        $request->validate(['files.*'=>'required|image|mimes:jpg,jpeg,png,webp,gif|max:5120']);
        $folder   = in_array($request->folder,['media','fleet','routes','packages','owner'])
                    ? $request->folder : 'media';
        $uploaded = 0;
        $failed   = 0;
        foreach($request->file('files',[]) as $file){
            try {
                $result = $file->store($folder,'public');
                if($result) $uploaded++;
                else        $failed++;
            } catch(\Exception $e){
                $failed++;
                \Log::error('Media upload failed: '.$e->getMessage());
            }
        }
        $msg = $uploaded.' image(s) uploaded to '.ucfirst($folder).'.';
        if($failed) $msg .= ' '.$failed.' failed — check file size (max 5MB).';
        return back()->with($failed ? 'error' : 'success', $msg);
    }
    public function mediaDelete(Request $request){
        if($r=$this->checkAuth())return $r;
        // path comes as folder/filename e.g. fleet/car.jpg
        $path = $request->input('path');
        if(!$path) return back()->with('error','No file specified.');
        // Security: only allow known folders
        $allowed = ['media','fleet','routes','packages','owner'];
        $folder  = explode('/', $path)[0] ?? '';
        if(!in_array($folder, $allowed)){
            return back()->with('error','Invalid file path.');
        }
        if(Storage::disk('public')->exists($path)){
            Storage::disk('public')->delete($path);
            return back()->with('success','File deleted.');
        }
        return back()->with('error','File not found.');
    }

    // ═══ GLOBAL SEARCH ═══════════════════════════════════════════════════════
    public function globalSearch(Request $request){
        if(!session('cms_admin'))return response()->json([],401);
        $q=trim($request->get('q',''));
        if(strlen($q)<2)return response()->json([]);
        $leads=Lead::where(fn($query)=>$query->where('name','like',"%{$q}%")->orWhere('phone','like',"%{$q}%")->orWhere('from_city','like',"%{$q}%")->orWhere('to_city','like',"%{$q}%"))->latest()->take(5)->get()->map(fn($l)=>['title'=>$l->name,'subtitle'=>$l->phone.' · '.$l->from_city.' → '.$l->to_city.' · '.ucfirst($l->status),'url'=>route('cms.leads.show',$l->id)])->all();
        $bookings=Booking::where(fn($query)=>$query->where('customer_name','like',"%{$q}%")->orWhere('customer_phone','like',"%{$q}%")->orWhere('booking_ref','like',"%{$q}%")->orWhere('from_city','like',"%{$q}%")->orWhere('to_city','like',"%{$q}%"))->latest()->take(4)->get()->map(fn($b)=>['title'=>$b->booking_ref.' — '.$b->customer_name,'subtitle'=>$b->from_city.' → '.$b->to_city.' · '.$b->travel_date?->format('d M Y'),'url'=>route('cms.bookings.show',$b->id)])->all();
        $routes=Route::where(fn($query)=>$query->where('from_city','like',"%{$q}%")->orWhere('to_city','like',"%{$q}%")->orWhere('highlight','like',"%{$q}%")->orWhere('tag','like',"%{$q}%"))->take(4)->get()->map(fn($r)=>['title'=>$r->from_city.' → '.$r->to_city,'subtitle'=>($r->distance_km?$r->distance_km.' km · ':'').($r->highlight??''),'url'=>route('cms.routes')])->all();
        $fleet=Fleet::where(fn($query)=>$query->where('name','like',"%{$q}%")->orWhere('type','like',"%{$q}%"))->take(4)->get()->map(fn($c)=>['title'=>$c->name,'subtitle'=>$c->type.' · ₹'.$c->rate_per_km.'/km · '.($c->is_active?'Active':'Inactive'),'url'=>route('cms.fleet')])->all();
        $blog=BlogPost::where(fn($query)=>$query->where('title','like',"%{$q}%")->orWhere('category','like',"%{$q}%")->orWhere('excerpt','like',"%{$q}%"))->latest()->take(3)->get()->map(fn($p)=>['title'=>$p->title,'subtitle'=>($p->category??'').' · '.ucfirst($p->status),'url'=>route('cms.blog.edit',$p->slug)])->all();
        return response()->json(['leads'=>$leads,'bookings'=>$bookings,'routes'=>$routes,'fleet'=>$fleet,'blog'=>$blog]);
    }
}
