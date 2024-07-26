<div class="account">
    <div class="account-info">
        <div class="user-photo">
            <img src="/assets/icons/User photo.svg" alt="User photo">
        </div>
        <div class="user-data">
            <h2>
            <?php echo htmlspecialchars($this->data['username'] ?? ''); ?>
            </h2>
            <p>
                City, Country
            </p>
        </div>
    </div>
    <div class="account-buttons">
        <button type="button" class="blind-button">Edit profile</button>
        <button type="button" class="blind-button" onclick="window.location.href='/index.php?action=logout'">Log Out</button>
    </div>
</div>
<section id="profile-edit">
    <div class="edit-container">
        <div class="heading-content">
            <div class="photo-username">
                <img src="/assets/icons/User photo.svg" alt="User photo">
                <div class="username-category">
                    <span><?php echo htmlspecialchars($this->data['username'] ?? ''); ?></span>
                    <span class="edit-category">/General</span>
                </div>
            </div>
            <div class="close-icon">
                <img src="/assets/icons/svg/x_pink.svg" alt="Close" id="close-profile-edit">
            </div>
        </div>
        <div class="categories-and-Form">
            <div class="category-list">
                <ul class="edit-category">
                    <li class="selected"><a href="#">General</a></li>
                    <li class="gray"><a href="#">Edit profile</a></li>
                    <div class="slice"></div>
                    <li class="delete-account"><a href="#">Delete account</a></li>
                </ul>
            </div>
        </div>
    </div>
</section>
