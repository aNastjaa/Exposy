<div class="hero-section">
    <h1>Your Guide to Events All Over Germany</h1>
    <h2>See Something You Like? <br>
    Save It to Your Account and Stay in the Know!</h2>
 </div>
 <div class="events-suggestion-heading">
    <h3>What's happening in <?= htmlspecialchars($this->data['city'] ?? 'your city'); ?>:</h3>
</div>
<div class="event-scroller">
    <button class="scroll-button left-scroll-button" id="left-arrow">
        <img src="/assets/icons/svg/arrow-left.svg" alt="Scroll left">
    </button>
    <div id="event-cards-container" class="event-cards-container">
        <?php if (!empty($this->data['localEvents'])): ?>
            <?php foreach ($this->data['localEvents'] as $event): ?>
                <div class="event-card">
                    <img src="<?= htmlspecialchars($event['img']) ?>" alt="<?= htmlspecialchars($event['title']) ?>">
                    <h4><?= htmlspecialchars($event['title']) ?></h4>
                    <p class="location"><?= htmlspecialchars($event['gallery']) ?></p>
                    <p class="event-date"><?= (new DateTime($event['date']))->format('F j, Y') ?></p>
                    <div class="buttons">
                        <a href="event-details.html?event=<?= urlencode($event['title']) ?>" class="button read-more">Read More</a>
                        <button class="button save-button" onclick="saveEvent('<?= addslashes($event['title']) ?>')">Save</button>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>Looks like <?= htmlspecialchars($this->data['city']); ?> is taking a little nap! 💤 <br> Check back soon or explore events in nearby cities to keep the fun rolling!</p>
        <?php endif; ?>
    </div>
    <button class="scroll-button right-scroll-button" id="right-arrow">
        <img src="/assets/icons/svg/arrow-right.svg" alt="Scroll right">
    </button>
</div>