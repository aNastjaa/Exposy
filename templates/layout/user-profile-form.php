<div id="additional-info" class="additional-info">
    <form class="profile-form" id="profile-form" method="POST" enctype="multipart/form-data" action="/account">
        <div class="form-header">    
            <h3>Complete your profile:</h3>
        </div>
        <div class="form-row">
            <div class="input-section">
                <label for="firstname">First name</label>
                <input type="text" placeholder="Enter your first name" id="firstname" name="firstname"
                    value="<?php echo htmlspecialchars($_POST['firstname'] ?? '', ENT_QUOTES); ?>">
                <?php $this->renderInputError('firstname'); ?>
                <ul class="error-list"></ul>
            </div>
            <div class="input-section">
                <label for="lastname">Last name</label>
                <input type="text" placeholder="Enter your last name" id="lastname" name="lastname"
                    value="<?php echo htmlspecialchars($_POST['lastname'] ?? '', ENT_QUOTES); ?>">
                <?php $this->renderInputError('lastname'); ?>
                <ul class="error-list"></ul>
            </div>
        </div>
        <div class="radio-section">
            <input type="radio" id="male" name="gender" value="Male" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Male') ? 'checked' : ''; ?>>
            <label for="male">Male</label>
            <input type="radio" id="female" name="gender" value="Female" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Female') ? 'checked' : ''; ?>>
            <label for="female">Female</label>
            <input type="radio" id="diverse" name="gender" value="Diverse" <?php echo (isset($_POST['gender']) && $_POST['gender'] === 'Diverse') ? 'checked' : ''; ?>>
            <label for="diverse">Diverse</label>
            <?php $this->renderInputError('gender'); ?>
            <ul class="error-list"></ul>
        </div>
        <div class="form-row">
            <div class="input-section">
                <label for="country">Choose your country</label>
                <select id="country" name="country">
                    <option value="none" selected disabled>--Choose your country--</option>
                    <?php
                    $countries = \Crmlva\Exposy\Enums\CountryEnum::getAll();
                    foreach ($countries as $c) {
                        $selected = (isset($_POST['country']) && $_POST['country'] === $c) ? 'selected' : '';
                        echo "<option value=\"$c\" $selected>$c</option>";
                    }
                    ?>
                </select>
                <?php $this->renderInputError('country'); ?>
                <ul class="error-list"></ul>
            </div>
            <div class="input-section">
                <label for="city">City</label>
                <input type="text" placeholder="Enter your city" id="city" name="city"
                    value="<?php echo htmlspecialchars($_POST['city'] ?? '', ENT_QUOTES); ?>">
                <?php $this->renderInputError('city'); ?>
                <ul class="error-list"></ul>
            </div>
        </div>
        <!-- User Photo Section -->
        <div class="photo-form-row">
            <div class="photo-input-section">
                <div class="user-photo-container">
                <img src="<?php echo htmlspecialchars(\Crmlva\Exposy\App::getUserPhotoUrl($this->data['photo'] ?? null), ENT_QUOTES); ?>" alt="<?php echo htmlspecialchars($this->data['alt_text'] ?? 'User photo', ENT_QUOTES); ?>" 
                        alt="<?php echo htmlspecialchars($this->data['alt_text'] ?? 'User photo', ENT_QUOTES); ?>" 
                        class="thumbnail-photo">
                </div>
                <label for="file-input" class="file-input-label">
                    <p class="file-input-text">Choose a photo</p>
                    <input type="file" id="file-input" name="file" accept="image/*" class="file-input">
                </label>
            </div>
            <div class="input-section">
                <label for="alt_text">Alternative text</label>
                <input type="text" id="alt_text" name="alt_text" placeholder="Enter alternative text"
                    value="<?php echo htmlspecialchars($this->data['alt_text'] ?? '', ENT_QUOTES); ?>">
                <?php $this->renderInputError('alt_text'); ?>
                <ul class="error-list"></ul>
            </div>
        </div>

        <div class="form-row submit-button full-width">
            <button type="submit" id="submit-button">Submit</button>
        </div>
    </form>
</div>

<!-- Placeholder for response messages -->
<div id="response-message" class="response-message" style="display: none;">
    <p class="response-text"></p>
</div>