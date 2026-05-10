{{-- ─── BOOKING MODAL ──────────────────────────────── --}}
<div class="modal-overlay" id="bookingModal" role="dialog" aria-modal="true" aria-labelledby="modalTitle">
    <div class="modal" role="document">
        <button class="modal__close" onclick="closeBookingModal()" aria-label="Close modal">✕</button>

        <h2 class="modal__title" id="modalTitle">Book Your Cab Now</h2>
        <p class="modal__sub">We confirm within 5 minutes. No advance payment for quote.</p>

        {{-- Quick action buttons --}}
        <div class="modal__actions">
            <a href="tel:+919324555165" class="modal__action modal__action--navy">
                <span class="modal__action-icon">📞</span>
                <div>
                    <div class="modal__action-label">Call Now</div>
                    <div class="modal__action-val">+91 93245 55165</div>
                </div>
            </a>
            <a href="https://wa.me/919324555165" class="modal__action modal__action--green" target="_blank" rel="noopener">
                <span class="modal__action-icon">💬</span>
                <div>
                    <div class="modal__action-label">WhatsApp</div>
                    <div class="modal__action-val">Instant reply</div>
                </div>
            </a>
        </div>

        <div class="modal__divider"><span>— or fill form —</span></div>

        {{-- Quick form --}}
        <form action="{{ route('lead.store') }}" method="POST" class="modal__form" id="bookingForm">
            @csrf
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="modal-name">Your Name</label>
                    <input class="form-input" type="text" id="modal-name" name="name" placeholder="Rajesh Sharma" required minlength="2" maxlength="100">
                </div>
                <div class="form-group">
                    <label class="form-label" for="modal-phone">Phone Number</label>
                    <input class="form-input" type="tel" id="modal-phone" name="phone" placeholder="98765 43210" pattern="[6-9][0-9]{9}" required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="modal-from">From</label>
                    <input class="form-input" type="text" id="modal-from" name="from_city" value="Delhi" required>
                </div>
                <div class="form-group">
                    <label class="form-label" for="modal-to">To</label>
                    <input class="form-input" type="text" id="modal-to" name="to_city" placeholder="Agra, Jaipur..." required>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label class="form-label" for="modal-date">Travel Date</label>
                    <input class="form-input" type="date" id="modal-date" name="travel_date">
                </div>
                <div class="form-group">
                    <label class="form-label" for="modal-car">Car Type</label>
                    <select class="form-select" id="modal-car" name="car_type">
                        <option value="any">Any Car Available</option>
                        <option value="dzire">Swift Dzire</option>
                        <option value="ertiga">Ertiga</option>
                        <option value="creta">Kia Creta</option>
                        <option value="innova">Innova Crysta</option>
                    </select>
                </div>
            </div>
            <button type="submit" class="btn btn--gold btn--full btn--lg">
                📤 Send Booking Request
            </button>
        </form>
    </div>
</div>
<div class="modal-backdrop" id="modalBackdrop" onclick="closeBookingModal()"></div>
