<?php

    if ($_SERVER["REQUEST_METHOD"] == "POST") {

        # FIX: Replace this email with recipient email
        $mail_to = "zahou.chancel@koyekola.com";
        
        # Sender Data
        $subject = trim($_POST["subject"]);
        
        $name = str_replace(array("\r","\n"),array(" "," ") , strip_tags(trim($_POST["name"])));
        
        $phone = trim($_POST["phone"]);
        
        $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
        $message = trim($_POST["message"]);
        
        if ( empty($name) OR !filter_var($email, FILTER_VALIDATE_EMAIL) OR empty($subject) OR empty($message)) {
            # Set a 400 (bad request) response code and exit.
            http_response_code(400);
            echo "Veuillez à remplir tous les champs du formulaire.";
            exit;
        }
        
        # Mail Content
        $content = "Name: $name\n";
        $content .= "Phone: $phone\n\n";
        $content .= "Email: $email\n\n";
        $content .= "Message:\n$message\n";

        # email headers.
        $headers = "From: $name <$email>";

        # Send the email.
        $success = mail($mail_to, $subject, $content, $headers);
        if ($success) {
            # Set a 200 (okay) response code.
            http_response_code(200);
            echo "Bravo! votre message a bien été envoyé.";
        } else {
            # Set a 500 (internal server error) response code.
            http_response_code(500);
            echo "Oops! nous ne pouvons pas envoyernotre message.";
        }

    } else {
        # Not a POST request, set a 403 (forbidden) response code.
        http_response_code(403);
        echo "Il ya un problème, réessayer s'il vous plait.";
    }

?>
