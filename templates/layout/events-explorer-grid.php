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
                <div class="event-cart-big" id="event-<?= nl2br($event['id']) ?>">
                    <div class="event-img">
                        <img src="<?= nl2br($event['img']) ?>" alt="<?= nl2br($event['title']) ?>">
                    </div>
                    <div class="event-info">
                        <h4 class="title"><?= nl2br($event['title']) ?></h4>
                        <h5 class="gallery-date-time"><?= nl2br($event['gallery']) ?></h5>
                        <h5 class="gallery-date-time"><?= nl2br($event['location']) ?></h5>
                        <h5 class="gallery-date-time"><?= nl2br($event['date']) ?> | <?= htmlspecialchars($event['time']) ?></h5>
                        <p class="description"><?= nl2br($event['description']) ?></p>
                        <div class="info-button">
                            <div class="event-contact-info">
                                <p class="contact-info"><?= nl2br($event['contact_information']) ?></p>
                            </div>
                            <div>
                                <form method="POST" action="/save-event">
                                    <input type="hidden" name="event_id" value="<?= htmlspecialchars($event['id']) ?>">
                                    <button type="submit" id="save-event-button" class="button save-event-button">Save</button>
                                </form>
                            </div>
                        </div>

                        <!-- Message container for feedback -->
                        <div id="message-container" style="display:none;">
                            <p id="message-text"></p>
                        </div>

                        <!-- Add Comment Button and Form -->
                        <div class="add-comment-container">
                            <div class="add-comment-form">
                                <form id="add-comment-form" method="POST" action="/add-comment">
                                    <input type="hidden" name="event_id" value="<?= htmlspecialchars($event['id']) ?>">
                                    <textarea name="comment" rows="1" placeholder="Add your comment here..." required></textarea>
                                    <button type="submit" id="add-comment-button" class="button blind-button add-comment-button">Send</button>
                                </form>
                            </div>
                        </div>

                        <!-- Existing Comments -->
                        <div class="event-comments">
                            <?php if (!empty($event['comments'])): ?>
                                <?php foreach ($event['comments'] as $comment): ?>
                                    <div class="comment">
                                        <div class="comment-heading">
                                            <strong><?= htmlspecialchars($comment['username'] ?? 'Anonymous') ?>:</strong>
                                        </div>
                                        <div class="comment-body" id="comment-body-<?= htmlspecialchars($comment['id']) ?>">
                                            <p><?= htmlspecialchars($comment['comment']) ?></p>
                                            <?php if (isset($this->data['username']) && $comment['username'] === $this->data['username']): ?>
                                               
                                                <!-- Edit and Delete Comments -->
                                                <div class="edit-delete">
                                                    <form method="POST" action="/update-comment" class="edit-comment-form" id="edit-comment-form-<?= htmlspecialchars($comment['id']) ?>">
                                                        <input type="hidden" name="comment_id" value="<?= htmlspecialchars($comment['id']) ?>">
                                                        <input type="text" name="comment" value="<?= htmlspecialchars($comment['comment']) ?>" required>
                                                        <button type="submit" id="edit-comment-button-<?= htmlspecialchars($comment['id']) ?>" class="edit-button">
                                                            <img src="/assets/icons/svg/pencil.svg" alt="Edit" class="edit-comment-icon">
                                                        </button>
                                                    </form>
                                                    <form method="POST" action="/delete-comment" class="delete-comment-form" id="delete-comment-form-<?= htmlspecialchars($comment['id']) ?>">
                                                        <input type="hidden" name="comment_id" value="<?= htmlspecialchars($comment['id']) ?>">
                                                        <button type="submit" id="delete-comment-button-<?= htmlspecialchars($comment['id']) ?>" class="delete-button">
                                                            <img src="/assets/icons/svg/trash.svg" alt="Delete" class="delete-comment-icon">
                                                        </button>
                                                    </form>
                                                </div>
                                            <?php endif; ?>
                                        </div>
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
