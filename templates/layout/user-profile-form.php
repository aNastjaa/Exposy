<div id="additional-info" class="additional-info">
    <form class="profile-form" id="profile-form" method="POST" enctype="multipart/form-data" action="/account">
        <h3>Complete your profile:</h3>
        <div class="form-row">
            <div class="input-section">
                <label for="firstname">First name</label>
                <input type="text" placeholder="Enter your first name" id="firstname" name="firstname"
                    value="<?php echo htmlspecialchars($_POST['firstname'] ?? '', ENT_QUOTES); ?>">
                <?php $this->renderInputError('firstname'); ?>
            </div>
            <div class="input-section">
                <label for="lastname">Last name</label>
                <input type="text" placeholder="Enter your last name" id="lastname" name="lastname"
                    value="<?php echo htmlspecialchars($_POST['lastname'] ?? '', ENT_QUOTES); ?>">
                <?php $this->renderInputError('lastname'); ?>
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
            </div>
            <div class="input-section">
                <label for="city">City</label>
                <input type="text" placeholder="Enter your city" id="city" name="city"
                    value="<?php echo htmlspecialchars($_POST['city'] ?? '', ENT_QUOTES); ?>">
                <?php $this->renderInputError('city'); ?>
            </div>
        </div>
        <div class="form-row">
        <div class="input-section">
            <label for="user-photo">Add your user photo here:</label>
            <input type="file" id="user-photo" name="user-photo">
            <?php $this->renderInputError('user-photo'); ?>
        </div>
        <div class="input-section">
            <label for="alt_text">Alternative Text</label>
            <input type="text" id="alt_text" name="alt_text" placeholder="Enter alternative text"
                value="<?php echo htmlspecialchars($this->data['alt_text'] ?? '', ENT_QUOTES); ?>">
            <?php $this->renderInputError('alt_text'); ?>
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