<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\PageSection;

class PageSectionSeeder extends Seeder
{
    public function run(): void
    {
        PageSection::truncate();

        $sections = [

            // ══════════════════════════════════════════
            // HOMEPAGE — HERO
            // ══════════════════════════════════════════
            ['homepage','hero','label',         'text', 'Top Label', 'Delhi\'s Trusted Outstation Cab Service', 1],
            ['homepage','hero','title_line1',   'text', 'Headline Line 1', 'Every Road Leads to', 2],
            ['homepage','hero','title_line2',   'text', 'Headline Line 2 (Gold)', 'a Great Journey.', 3],
            ['homepage','hero','description',   'textarea', 'Hero Description', 'Book outstation cabs from Delhi to Agra, Rajasthan, Himachal & beyond. AC cars, expert drivers, all-inclusive pricing with zero hidden charges.', 4],
            ['homepage','hero','cta_primary',   'text', 'Primary Button Text', 'Book Your Cab Now', 5],
            ['homepage','hero','cta_secondary', 'text', 'Secondary Button Text', 'View Fleet', 6],

            // ══════════════════════════════════════════
            // HOMEPAGE — TICKER (scrolling bar)
            // ══════════════════════════════════════════
            ['homepage','ticker','item_1', 'text', 'Ticker Item 1', 'All-Inclusive Pricing', 1],
            ['homepage','ticker','item_2', 'text', 'Ticker Item 2', 'Verified Drivers', 2],
            ['homepage','ticker','item_3', 'text', 'Ticker Item 3', '24/7 Support', 3],
            ['homepage','ticker','item_4', 'text', 'Ticker Item 4', 'No Surge Pricing', 4],
            ['homepage','ticker','item_5', 'text', 'Ticker Item 5', 'GPS Tracked', 5],
            ['homepage','ticker','item_6', 'text', 'Ticker Item 6', 'Free Cancellation*', 6],
            ['homepage','ticker','item_7', 'text', 'Ticker Item 7', 'Pan India Travel', 7],
            ['homepage','ticker','item_8', 'text', 'Ticker Item 8', 'UPI / Cash Payment', 8],

            // ══════════════════════════════════════════
            // HOMEPAGE — WHY CHOOSE US section
            // ══════════════════════════════════════════
            ['homepage','why_us','section_eyebrow', 'text', 'Section Eyebrow', 'Why RK Shah', 1],
            ['homepage','why_us','section_title',   'text', 'Section Title', 'Not Just a Cab. A Complete Journey.', 2],
            ['homepage','why_us','section_desc',    'textarea', 'Section Description', 'Everything that matters for a comfortable, safe, stress-free outstation trip.', 3],

            ['homepage','why_us','usp_1_icon',  'text',     'USP 1 Icon',  '🛡️', 4],
            ['homepage','why_us','usp_1_title', 'text',     'USP 1 Title', 'Police Verified Drivers Only', 5],
            ['homepage','why_us','usp_1_desc',  'textarea', 'USP 1 Description', 'Every driver is background checked, licensed, and trained in professional conduct. No random driver allocation.', 6],

            ['homepage','why_us','usp_2_icon',  'text',     'USP 2 Icon',  '💰', 7],
            ['homepage','why_us','usp_2_title', 'text',     'USP 2 Title', 'Transparent All-In Pricing', 8],
            ['homepage','why_us','usp_2_desc',  'textarea', 'USP 2 Description', 'No hidden charges. No surprise tolls. No surge pricing. The price we quote is the price you pay.', 9],

            ['homepage','why_us','usp_3_icon',  'text',     'USP 3 Icon',  '📍', 10],
            ['homepage','why_us','usp_3_title', 'text',     'USP 3 Title', 'Live GPS Tracking', 11],
            ['homepage','why_us','usp_3_desc',  'textarea', 'USP 3 Description', 'Share your trip link with family. Track your cab in real-time for complete peace of mind.', 12],

            ['homepage','why_us','usp_4_icon',  'text',     'USP 4 Icon',  '🚗', 13],
            ['homepage','why_us','usp_4_title', 'text',     'USP 4 Title', 'Well-Maintained Fleet', 14],
            ['homepage','why_us','usp_4_desc',  'textarea', 'USP 4 Description', 'All cars serviced every 5,000 km. AC guaranteed. Sanitized before every trip. Less than 3 years old.', 15],

            ['homepage','why_us','usp_5_icon',  'text',     'USP 5 Icon',  '📞', 16],
            ['homepage','why_us','usp_5_title', 'text',     'USP 5 Title', 'Direct Owner Support 24/7', 17],
            ['homepage','why_us','usp_5_desc',  'textarea', 'USP 5 Description', 'You call RK Shah directly — not a call centre. Real help any hour of the day or night.', 18],

            ['homepage','why_us','usp_6_icon',  'text',     'USP 6 Icon',  '🔄', 19],
            ['homepage','why_us','usp_6_title', 'text',     'USP 6 Title', 'Free Cancellation*', 20],
            ['homepage','why_us','usp_6_desc',  'textarea', 'USP 6 Description', 'Plans change — we understand. Cancel up to 24 hours before departure with no questions asked.', 21],

            // ══════════════════════════════════════════
            // HOMEPAGE — HOW IT WORKS
            // ══════════════════════════════════════════
            ['homepage','how_it_works','section_eyebrow', 'text', 'Section Eyebrow', 'Simple Process', 1],
            ['homepage','how_it_works','section_title',   'text', 'Section Title', 'Booked in Under 2 Minutes', 2],
            ['homepage','how_it_works','section_desc',    'textarea', 'Section Description', 'No app download. No registration. Call or fill the form — and your cab is confirmed.', 3],

            ['homepage','how_it_works','step_1_num',   'text', 'Step 1 Number', '01', 4],
            ['homepage','how_it_works','step_1_icon',  'text', 'Step 1 Icon', '📋', 5],
            ['homepage','how_it_works','step_1_title', 'text', 'Step 1 Title', 'Enter Your Route', 6],
            ['homepage','how_it_works','step_1_desc',  'textarea', 'Step 1 Description', 'Pick your from/to city, travel date, and preferred car from the booking form.', 7],

            ['homepage','how_it_works','step_2_num',   'text', 'Step 2 Number', '02', 8],
            ['homepage','how_it_works','step_2_icon',  'text', 'Step 2 Icon', '📞', 9],
            ['homepage','how_it_works','step_2_title', 'text', 'Step 2 Title', 'Get Instant Quote', 10],
            ['homepage','how_it_works','step_2_desc',  'textarea', 'Step 2 Description', 'We call or WhatsApp you with your all-inclusive price within 5 minutes.', 11],

            ['homepage','how_it_works','step_3_num',   'text', 'Step 3 Number', '03', 12],
            ['homepage','how_it_works','step_3_icon',  'text', 'Step 3 Icon', '💳', 13],
            ['homepage','how_it_works','step_3_title', 'text', 'Step 3 Title', 'Confirm & Pay Advance', 14],
            ['homepage','how_it_works','step_3_desc',  'textarea', 'Step 3 Description', 'Pay a small token advance via UPI/NEFT. Balance due on the day of journey.', 15],

            ['homepage','how_it_works','step_4_num',   'text', 'Step 4 Number', '04', 16],
            ['homepage','how_it_works','step_4_icon',  'text', 'Step 4 Icon', '🛣️', 17],
            ['homepage','how_it_works','step_4_title', 'text', 'Step 4 Title', 'Sit Back & Travel', 18],
            ['homepage','how_it_works','step_4_desc',  'textarea', 'Step 4 Description', 'Driver arrives on time. Share live tracking with family. Enjoy stress-free travel.', 19],

            // ══════════════════════════════════════════
            // HOMEPAGE — CTA BANNER
            // ══════════════════════════════════════════
            ['homepage','cta','title',       'text',     'CTA Title',       'Ready for Your Next Adventure?', 1],
            ['homepage','cta','description', 'textarea', 'CTA Description', 'Call RK Shah directly or WhatsApp us — instant response, honest pricing, unforgettable journey.', 2],
            ['homepage','cta','btn_1_text',  'text',     'Button 1 Text',   'Call: +91 93245 55165', 3],
            ['homepage','cta','btn_2_text',  'text',     'Button 2 Text',   'WhatsApp Us Now', 4],

            // ══════════════════════════════════════════
            // HOMEPAGE — TRUST BAR items
            // ══════════════════════════════════════════
            ['homepage','trust_bar','item_1', 'text', 'Trust Item 1', '🔒 Police Verified Drivers', 1],
            ['homepage','trust_bar','item_2', 'text', 'Trust Item 2', '📍 GPS Tracked Cars', 2],
            ['homepage','trust_bar','item_3', 'text', 'Trust Item 3', '💰 Zero Hidden Charges', 3],
            ['homepage','trust_bar','item_4', 'text', 'Trust Item 4', '🏆 Google Verified Business', 4],
            ['homepage','trust_bar','item_5', 'text', 'Trust Item 5', '🚗 Well Maintained Fleet', 5],

            // ══════════════════════════════════════════
            // ABOUT PAGE — Story
            // ══════════════════════════════════════════
            ['about','hero','title',       'text',     'Page Title',       'Built on Trust. Driven by Passion.', 1],
            ['about','hero','description', 'textarea', 'Hero Description', 'Since 2015, RK Shah Car Rental has been the go-to outstation cab service for thousands of Delhi families. Not because of ads or algorithms — but because of one man\'s commitment to doing things right.', 2],

            ['about','story','heading',    'text',     'Story Heading', 'Not a company. A commitment.', 1],
            ['about','story','para_1',     'textarea', 'Story Paragraph 1', 'RK Shah started this business in 2015 with a single car and a simple principle: treat every passenger the way you would want your own family to be treated. No shortcuts, no false promises, no hidden charges.', 2],
            ['about','story','para_2',     'textarea', 'Story Paragraph 2', 'In the early days, RK Shah drove every trip himself. He learned every highway, every shortcut, every good dhaba on the Yamuna Expressway, every viewpoint on the Manali road. That first-hand knowledge is what he passes on to every driver he works with today.', 3],
            ['about','story','para_3',     'textarea', 'Story Paragraph 3', 'Today the fleet has grown to four well-maintained cars. But the philosophy has not changed. RK Shah personally handles every booking. When you call the number on this website, you speak to the owner, not a call centre agent.', 4],
            ['about','story','para_4',     'textarea', 'Story Paragraph 4', 'That is why 96% of new customers come through referrals. Not advertising. Not discounts. Just honest service, on time, every time.', 5],

            ['about','owner','name',       'text', 'Owner Name',  'RK Shah', 1],
            ['about','owner','title',      'text', 'Owner Title', 'Founder & Owner', 2],
            ['about','owner','location',   'text', 'Owner Location', 'Soniya Vihar, Delhi · Since 2015', 3],
            ['about','owner','quote',      'textarea', 'Owner Quote', 'When you book with me, you are not a ticket number in a system. You are someone whose family I am responsible for. I take that seriously.', 4],

            // ══════════════════════════════════════════
            // ABOUT PAGE — Trust metrics
            // ══════════════════════════════════════════
            ['about','metrics','stat_1_value', 'text', 'Stat 1 Value', '96%',     1],
            ['about','metrics','stat_1_label', 'text', 'Stat 1 Label', 'Customer Return Rate', 2],
            ['about','metrics','stat_1_desc',  'text', 'Stat 1 Description', 'Once a customer travels with us, they come back', 3],
            ['about','metrics','stat_2_value', 'text', 'Stat 2 Value', '70%',     4],
            ['about','metrics','stat_2_label', 'text', 'Stat 2 Label', 'Referral Bookings', 5],
            ['about','metrics','stat_2_desc',  'text', 'Stat 2 Description', 'Majority of new bookings come from referrals', 6],
            ['about','metrics','stat_3_value', 'text', 'Stat 3 Value', '4.9',     7],
            ['about','metrics','stat_3_label', 'text', 'Stat 3 Label', 'Google Rating', 8],
            ['about','metrics','stat_3_desc',  'text', 'Stat 3 Description', 'Across 180+ verified reviews', 9],
            ['about','metrics','stat_4_value', 'text', 'Stat 4 Value', '< 5 min', 10],
            ['about','metrics','stat_4_label', 'text', 'Stat 4 Label', 'Response Time', 11],
            ['about','metrics','stat_4_desc',  'text', 'Stat 4 Description', 'How quickly RK Shah picks up or calls back', 12],

            // ══════════════════════════════════════════
            // ABOUT PAGE — CTA
            // ══════════════════════════════════════════
            ['about','cta','title',       'text',     'CTA Title', 'Travel with Someone You Can Trust', 1],
            ['about','cta','description', 'textarea', 'CTA Description', 'Ten years on the road. 1,200+ families served. The same phone number, the same owner, the same promise.', 2],

        ];

        $order = 0;
        foreach ($sections as [$page, $section, $key, $type, $label, $value, $sort]) {
            PageSection::create([
                'page'       => $page,
                'section'    => $section,
                'key'        => $key,
                'type'       => $type,
                'label'      => $label,
                'value'      => $value,
                'sort_order' => $sort,
            ]);
        }

        $this->command->info('  ✅ Page sections seeded (' . count($sections) . ' items)');
    }
}
