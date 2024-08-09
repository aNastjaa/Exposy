<div class="saved-events-wrapper">
    <div class="saved-events" id="rounded-tab-right">
        <h3>Saved Events</h3>
    </div>
    <div class="saved-events-container">
    <div class="events-cards-container">
        <?php if (!empty($this->data['savedEvents'])): ?>
            <?php foreach ($this->data['savedEvents'] as $event): ?>
                <div class="event-cart-big" id="event-<?= nl2br($event['id']) ?>">
                    <div class="event-img"> 
                        <img src="<?= ($event['img']) ?>" alt="<?= nl2br($event['title']) ?>">
                    </div>
                    <div class="event-info">
                        <h4 class="title"><?= nl2br($event['title']) ?></h4>
                        <h5 class="gallery-date-time">
                            <?= nl2br($event['gallery']) ?> 
                        </h5> 
                        <h5 class="gallery-date-time">
                            <?= nl2br($event['location'])?> 
                        </h5>
                        <h5 class="gallery-date-time">
                            <?= nl2br($event['date']) ?> | 
                            <?= nl2br($event['time']) ?>
                        </h5>
                        <p class="description"><?= nl2br($event['description']) ?></p>
                        <div class="info-button">
                            <div class="event-contact-info">
                                <p class="contact-info"><?= nl2br($event['contact_information']) ?></p>
                            </div>
                            <div class="delete-button">
                                <form method="POST" action="/delete-saved-event" style="display:inline;">
                                    <input type="hidden" name="event_id" value="<?= nl2br($event['id']) ?>">
                                    <button type="submit" class="button delete-event-button">
                                        <img src="/assets/icons/svg/trash.svg" alt="Delete">
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No saved events yet 👀 <br> Save some events to see them here!</p>
        <?php endif; ?>
    </div>
</div>
</div>
