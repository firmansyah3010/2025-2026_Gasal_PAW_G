<form action="processData.php" method="POST">
    <?php $errors = $errors ?? []; ?>

    <!-- Surname -->
    <label>Surname:</label><br>
    <input type="text" name="surname" value="<?= htmlspecialchars($_POST['surname'] ?? '') ?>"><br>
    <small style="color:red"><?= implode('<br>', array_filter($errors, fn($e) => str_contains($e, 'surname'))) ?></small><br>

    <!-- Username -->
    <label>Username:</label><br>
    <input type="text" name="username" value="<?= htmlspecialchars($_POST['username'] ?? '') ?>"><br>
    <small style="color:red"><?= implode('<br>', array_filter($errors, fn($e) => str_contains($e, 'Username'))) ?></small><br>

    <!-- Email -->
    <label>Email:</label><br>
    <input type="email" name="email" value="<?= htmlspecialchars($_POST['email'] ?? '') ?>"><br>
    <small style="color:red"><?= implode('<br>', array_filter($errors, fn($e) => str_contains($e, 'Email'))) ?></small><br>

    <!-- Password -->
    <label>Password:</label><br>
    <input type="password" name="password"><br>
    <small style="color:red"><?= implode('<br>', array_filter($errors, fn($e) => str_contains($e, 'Password'))) ?></small><br>

    <!-- Alamat -->
    <label>Alamat:</label><br>
    <textarea name="address" rows="3" cols="30"><?= htmlspecialchars($_POST['address'] ?? '') ?></textarea><br>
    <small style="color:red"><?= implode('<br>', array_filter($errors, fn($e) => str_contains($e, 'Alamat'))) ?></small><br>

    <!-- Semester -->
    <label>Semester:</label><br>
    <select name="semester">
        <?php
        for ($i = 1; $i <= 4; $i++) {
            $selected = (isset($_POST['semester']) && $_POST['semester'] == $i) ? 'selected' : '';
            echo "<option value='$i' $selected>$i</option>";
        }
        ?>
    </select><br>
    <small style="color:red"><?= implode('<br>', array_filter($errors, fn($e) => str_contains($e, 'Semester'))) ?></small><br>

    <!-- Gender -->
    <label>Gender:</label><br>
    <input type="radio" name="gender" value="Laki-laki" <?= (($_POST['gender'] ?? '') === 'Laki-laki') ? 'checked' : '' ?>> Laki-laki
    <input type="radio" name="gender" value="Perempuan" <?= (($_POST['gender'] ?? '') === 'Perempuan') ? 'checked' : '' ?>> Perempuan<br>
    <small style="color:red"><?= implode('<br>', array_filter($errors, fn($e) => str_contains($e, 'Gender'))) ?></small><br>

    <!-- Hobi -->
    <label>Hobi:</label><br>
    <?php
    $hobiOptions = ['Membaca','Olahraga','Musik','Gaming'];
    foreach ($hobiOptions as $h) {
        $checked = (isset($_POST['hobi']) && in_array($h, $_POST['hobi'])) ? 'checked' : '';
        echo "<input type='checkbox' name='hobi[]' value='$h' $checked> $h ";
    }
    ?><br>
    <small style="color:red"><?= implode('<br>', array_filter($errors, fn($e) => str_contains($e, 'Hobi'))) ?></small><br><br>

    <!-- Birthdate -->
    <label>Birthdate:</label><br>
    <input type="date" name="birthdate" value="<?= htmlspecialchars($_POST['birthdate'] ?? '') ?>"><br>
    <small style="color:red"><?= implode('<br>', array_filter($errors, fn($e) => str_contains($e, 'Birthdate'))) ?></small><br><br>

    <!-- Submit -->
    <input type="submit" value="Kirim Data">
</form>
