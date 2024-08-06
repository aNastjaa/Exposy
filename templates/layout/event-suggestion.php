<div class="hero-section">
    <h1>Your Guide to Events All Over Germany</h1>
    <h2>See Something You Like? <br>
    Save It to Your Account and Stay in the Know!</h2>
 </div>
 <div class="events-suggestion-heading">
    <h3>What's happening in <?php echo htmlspecialchars($this->data['city'] ?? 'your city'); ?>?</h3>
 </div>
 <div class="event-scroller">
    <button class="scroll-button left-scroll-button"><img src="/assets/icons/svg/arrow-left.svg" alt="Scroll left"></button> 
    <div id="event-cards-container" class="event-cards-container">
                <!-- Event cards will be dynamically added here -->
    </div>
    <button class="scroll-button right-scroll-button"><img src="/assets/icons/svg/arrow-right.svg" alt="Scrol right"></button>
</div>