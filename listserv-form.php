<?php
/*
Template Name: Subscribe to LISTSERV
*/

get_header(); ?>

<?php
    session_start();

    $response_message = '';
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $firstname = sanitize_text_field($_POST["firstname"]);
        $lastname = sanitize_text_field($_POST["lastname"]);
        $email = sanitize_email($_POST["email"]);

        if (!empty($firstname) && !empty($lastname) && !empty($email) && is_email($email)) {
            $to = "listserv@lists.ufl.edu";
            $subject = "";
            $message = 'SUBSCRIBE <INSERT LISTSERV LIST NAME HERE' . $firstname . ' ' . $lastname;
            $headers = 'From: ' . $email . "\r\n" .
                'Reply-To: ' . $email . "\r\n" .
                'X-Mailer: PHP/' . phpversion();

            mail($to, $subject, $message, $headers);
            $_SESSION['response_message'] = "You have been subscribed successfully! Please check your email for confirmation.";
        } else {
            $_SESSION['response_message'] = "Please fill in all fields correctly.";
        }

        // Redirect to the same page to prevent form resubmission on page refresh
        header("Location: " . $_SERVER["REQUEST_URI"]);
        exit;
    }

    // If there's a message in the session, store it in $response_message and then remove it from the session
    if (isset($_SESSION['response_message'])) {
        $response_message = $_SESSION['response_message'];
        unset($_SESSION['response_message']);
    }
?>

<div id="primary" class="content-area">
    <main id="main" class="site-main" role="main">
        <div class="container">
            <form class="listserv-form" action="" method="post">
                <h2>Subscribe to LISTSERV</h2>
                <p><?php echo $response_message; ?></p>
                <div style="display: inline-block; margin-right: 10px;">
                    <label for="firstname">First Name<span style="color: red;">*</span></label>
                    <input type="text" id="firstname" name="firstname" required>
                </div>
                <div style="display: inline-block;">
                    <label for="lastname">Last Name<span style="color: red;">*</span></label>
                    <input type="text" id="lastname" name="lastname" required>
                </div>
                <div>
                    <label for="email">Email<span style="color: red;">*</span></label>
                    <input type="email" id="email" name="email" required>
                </div>
                <div>
                    <input type="submit" name="submit" value="Subscribe">
                </div>
            </form>
        </div>
    </main>
</div>

<style>
.content-area {
    position: relative;
}
/* Set the heading font and color */
.listserv-form h1, h3 {
  font-family: inherit, sans-serif;
  color: #00447c;
}

/* New color for h2 */
.listserv-form h2 {
  font-family: inherit, sans-serif;
  color: #00529b;
}

/* Set the body text font and color */
.listserv-form p, a {
  font-family: inherit, serif;
  color: #333333;
}

/* Style the form inputs */
.listserv-form form input[type="text"], form input[type="email"], form textarea {
  font-size: 18px;
  padding: 5px;
  border: 1px solid #333333;
  font-family: inherit, sans-serif;
}

.listserv-form, form input[type="text"], form textarea {
  font-size: 18px;
  padding: 5px;
  border: 1px solid #333333;
  font-family: inherit, sans-serif;
}

/* Add margin to the submit button */
.listserv-form input[type="submit"] {
  margin-top: 10px;
}

/* Style the form */
.listserv-form {
  background-color: #f5f2e5;
  padding: 20px;
  border: 2px solid #00529b;
  border-radius: 5px;
}

/* Style the submit button */
.listserv-form input[type="submit"] {
  background-color: #00447c;
  color: #ffffff;
  padding: 10px 20px;
  border: none;
  font-family: inherit, sans-serif;
  transition: background-color 0.3s ease;
}

/* Hover state */
input[type="submit"]:hover {
  background-color: #002952; 
  color: #ffffff;
  cursor: pointer;
}

/* Button press animation */
input[type="submit"]:active {
  transform: scale(0.95); 
  transition: transform 0.1s ease; 
}

/* Center the form in the container */
.container {
  display: flex;
  justify-content: center;
  align-items: center;
  height: 75vh; /* adjust this as necessary */
  padding: 20px;
}


</style>

<?php get_footer(); ?>
