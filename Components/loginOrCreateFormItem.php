<?php
function loginOrCreateFormItem($type, $message)
{
    $input = '';
    $btn = '';
    if ($type == 'login') {
        $btn = '<button type="submit" name="login" class="createBtn">Logga in</button>';
    }
    if ($type == 'createUser') {
        $btn = '<button type="submit" name="create" class="createBtn">Skapa konto</button>';
        $input = '<label class="createInput">Lösenord: </label>
                  <input name="passwordAgain" class="createInput" type="password" />';
    }

    $content = "
    <article class=\"createUserFormContainer\">
        <img src=\"./assets/images/background.png\" class=\"background___img\" />
        <form class=\"createUserForm\" method=\"POST\">
            <section class=\"createInputContainer\">
                <label class=\"createInput\">Användarnamn: </label>
                <input name=\"username\" class=\"createInput\" />
                <label class=\"createInput\">Lösenord: </label>
                <input name=\"password\" class=\"createInput\" type=\"password\" />
                $input
                <p class=\"createUserMessage\">
                    $message
                </p>
            </section>
            <section class=\"createBtnContainer\">
                $btn
            </section>
        </form>
    </article>";

    return $content;
}
?>
