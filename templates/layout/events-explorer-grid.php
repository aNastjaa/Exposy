<div class="events-explorer-heading" id="tab">
    <h3>Explore upcoming Events Beyond <?= htmlspecialchars($this->data['city'] ?? 'your city'); ?>:</h3>
</div>
<div class="events-explorer">
    <h4>Filter by city or/and category to find your next adventure</h4>
    <form method="GET" action="">
        <div class="filter-options">
            <select name="city-filter">
                <option value="none" <?= $this->data['selectedCity'] === 'none' ? 'selected' : '' ?>>--All cities--</option>
                <?php foreach (Crmlva\Exposy\Enums\CityEnum::values() as $city): ?>
                    <option value="<?= htmlspecialchars($city) ?>" <?= $this->data['selectedCity'] === $city ? 'selected' : '' ?>>
                        <?= htmlspecialchars($city) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <select name="category-filter">
                <option value="none" <?= $this->data['selectedCategory'] === 'none' ? 'selected' : '' ?>>--All categories--</option>
                <?php foreach (Crmlva\Exposy\Enums\CategoryEnum::values() as $category): ?>
                    <option value="<?= htmlspecialchars($category) ?>" <?= $this->data['selectedCategory'] === $category ? 'selected' : '' ?>>
                        <?= htmlspecialchars($category) ?>
                    </option>
                <?php endforeach; ?>
            </select>

            <button type="submit" id="filter-button">Filter</button>
        </div>
    </form>
    <div class="global-events-cards-container">
        <?php if (!empty($this->data['globalEvents'])): ?>
            <?php foreach ($this->data['globalEvents'] as $event): ?>
                <div class="event-cart-big" id="event-<?= htmlspecialchars($event['id']) ?>">
                    <div class="event-img">
                        <img src="<?= htmlspecialchars($event['img']) ?>" alt="<?= htmlspecialchars($event['title']) ?>">
                    </div>
                    <div class="event-info">
                        <h4 class="title"><?= htmlspecialchars($event['title']) ?></h4>
                        <h5 class="gallery-date-time"><?= htmlspecialchars($event['gallery']) ?></h5>
                        <h5 class="gallery-date-time"><?= htmlspecialchars($event['location']) ?></h5>
                        <h5 class="gallery-date-time"><?= htmlspecialchars($event['date']) ?> | <?= htmlspecialchars($event['time']) ?></h5>
                        <p class="description"><?= htmlspecialchars($event['description']) ?></p>
                        <div class="info-button">
                            <div class="event-contact-info">
                                <p class="contact-info"><?= htmlspecialchars($event['contact_information']) ?></p>
                            </div>
                            <div>
                                <form method="POST" action="/save-event">
                                    <input type="hidden" name="event_id" value="<?= htmlspecialchars($event['id']) ?>">
                                    <button type="submit" class="button save-event-button">Save</button>
                                </form>
                            </div>
                        </div>

                        <!-- Add Comment Form -->
                        <div class="add-comment-form">
                            <form method="POST" action="/add-comment">
                                <input type="hidden" name="event_id" value="<?= htmlspecialchars($event['id']) ?>">
                                <textarea name="comment" rows="3" placeholder="Add a comment..." required></textarea>
                                <button type="submit" class="button add-comment-button">Send</button>
                            </form>
                        </div>

                        <div class="event-comments">
                            <?php if (!empty($event['comments'])): ?>
                                <?php foreach ($event['comments'] as $comment): ?>
                                    <div class="comment">
                                        <p><strong><?= htmlspecialchars($comment['username'] ?? 'Anonymous') ?>:</strong> <?= htmlspecialchars($comment['comment']) ?></p>
                                        <?php if (isset($this->data['username']) && $comment['username'] === $this->data['username']): ?>
                                            <!-- Allow editing and deleting only for the author -->
                                            <form method="POST" action="/update-comment">
                                                <input type="hidden" name="comment_id" value="<?= htmlspecialchars($comment['id']) ?>">
                                                <input type="text" name="comment" value="<?= htmlspecialchars($comment['comment']) ?>">
                                                <button type="submit" class="button">Update</button>
                                            </form>
                                            <form method="POST" action="/delete-comment">
                                                <input type="hidden" name="comment_id" value="<?= htmlspecialchars($comment['id']) ?>">
                                                <button type="submit" class="button">Delete</button>
                                            </form>
                                        <?php endif; ?>
                                    </div>
                                <?php endforeach; ?>
                            <?php else: ?>
                                <p>No comments yet. Be the first to comment!</p>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No global events available at the moment. Please check back later!</p>
        <?php endif; ?>
    </div>
</div>
