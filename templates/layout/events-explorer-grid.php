<div class="events-explorer-heading">
    <h3>Explore upcoming Events Beyond <?php echo htmlspecialchars($this->data['city'] ?? 'your city'); ?> : </h3>
 </div>
 <div class="events-explorer">
    <div class="filter-options">
        <select name="city-filter">
        <option value="none" selected disabled>--All cities--</option>
            <option value="Berlin">Berlin</option>
            <option value="Bremen">Bremen</option>
            <option value="Cologne">Cologne</option>
            <option value="Duisburg">Duisburg</option>
            <option value="Düsseldorf">Düsseldorf</option>
            <option value="Essen">Essen</option>
            <option value="Frankfurt">Frankfurt</option>
            <option value="Freiburg">Freiburg</option>
            <option value="Hamburg">Hamburg</option>
            <option value="Hanover">Hanover</option>
            <option value="Karlsruhe">Karlsruhe</option>
            <option value="Munich">Munich</option>
            <option value="Nuremberg">Nuremberg</option>
            <option value="Potsdam">Potsdam</option>
            <option value="Stuttgart">Stuttgart</option>
            <option value="Wuppertal">Wuppertal</option>
        </select>

        <select name="category-filter">
            <option value="none" selected disabled>--All categories--</option>
            <option value="Contemporary Art">Contemporary Art</option>
            <option value="Historical Art">Historical Art</option>
            <option value="Digital Art">Digital Art</option>
            <option value="Sculpture">Sculpture</option>
        </select>
    </div>
 

    <div class="global-events-cards-container">
        <?php if (!empty($this->data['globalEvents'])): ?>
            <?php foreach ($this->data['globalEvents'] as $event): ?>
                <div class="event-cart-big">
                    <div class="event-img"> 
                        <img src="<?= htmlspecialchars($event['img']) ?>" alt="<?= htmlspecialchars($event['title']) ?>">
                    </div>
                    <div class="event-info">
                        <h4 class="title"><?= htmlspecialchars($event['title']) ?></h4>
                        <h5 class="gallery-date-time"><?= htmlspecialchars($event['gallery']) ?> <br> <?= htmlspecialchars($event['date']) ?> | <?= htmlspecialchars($event['time']) ?></h5>
                        <p class="description"><?= htmlspecialchars($event['description']) ?></p>
                        <div class="info-button">
                            <div class="event-contact-info">
                                <p class="contact-info"><?= htmlspecialchars($event['contact_information']) ?></p>
                            </div>
                            <div>
                                <button class="save-event-button">Save</button>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        <?php else: ?>
            <p>No global events available at the moment. Please check back later!</p>
        <?php endif; ?>
    </div>
</div>
