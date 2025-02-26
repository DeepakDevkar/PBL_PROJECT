<?php
// Ensure form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Database connection
    $host = "localhost";
    $username = "root";
    $password = "";
    $database = "project_pbl";

    $conn = new mysqli($host, $username, $password, $database);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    // Collecting form data
    $firstName = $conn->real_escape_string($_POST['first_name']);
    $lastName = $conn->real_escape_string($_POST['last_name']);
    $email = $conn->real_escape_string($_POST['email']);
    $phone = $conn->real_escape_string($_POST['phone']);
    $city = $conn->real_escape_string($_POST['city']);

    // Image upload handling
    $profileImage = "";

    if (isset($_FILES['profileImage']) && $_FILES['profileImage']['error'] == 0) {
        $uploadDir = "uploads/";

        // Ensure the "uploads" folder exists, if not, create it
        if (!is_dir($uploadDir)) {
            mkdir($uploadDir, 0777, true);
        }

        // Generate unique file name to prevent overwriting
        $fileName = time() . "_" . basename($_FILES['profileImage']['name']);
        $profileImage = $uploadDir . $fileName;

        // Move uploaded file to "uploads" folder
        if (!move_uploaded_file($_FILES['profileImage']['tmp_name'], $profileImage)) {
            die("Error uploading image.");
        }
    }

    // Insert data into database
    $sql = "INSERT INTO pbl_pro (first_name, last_name, email, phone, city, profile_image) 
            VALUES ('$firstName', '$lastName', '$email', '$phone', '$city', '$profileImage')";

    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('Data stored successfully!'); window.location.href='add1.php';</script>";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Multi-step Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha1/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons/font/bootstrap-icons.css" rel="stylesheet">
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css" />

    <link rel="stylesheet" type="text/css" href="css/bootstrap.css" />
    <link rel="stylesheet" type="text/css" href="css/font-awesome.min.css" />
    <link href="css/style.css" rel="stylesheet" />
    <link href="css/responsive.css" rel="stylesheet" />

    <style>
        .step-icon {
            font-size: 1.5rem;
            margin-right: 8px;
        }

        .step {
            display: none;
        }

        .step.active {
            display: block;
        }

        .step-buttons {
            margin-top: 20px;
        }

        .progress-bar {
            height: 20px;
            position: relative;
        }

        .progress-bar::after {
            content: attr(data-step);
            position: absolute;
            top: 0;
            left: 50%;
            transform: translateX(-50%);
            font-weight: bold;
            color: #fff;
        }

        /* Profile image upload fix */
        .profile-container {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            cursor: pointer;
            width: 160px;
            height: 160px;
            margin: 0 auto;
        }

        .profile-pic {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #ccc;
            display: none;
            position: absolute;
        }

        .profile-placeholder {
            width: 100%;
            height: 100%;
            border-radius: 50%;
            background-color: #e0e0e0;
            display: flex;
            justify-content: center;
            align-items: center;
            font-size: 2rem;
            color: #666;
            border: 3px dashed #ccc;
            position: absolute;
            z-index: 1;
        }

        .profile-container input {
            position: absolute;
            width: 100%;
            height: 100%;
            opacity: 0;
            cursor: pointer;
            z-index: 2;
        }
    </style>
</head>

<body>
<?php include 'header.php'; ?>
    <div class="container mt-5">
        <div class="card">
            <div class="card-header text-center">
                <h4> Registration Form</h4>
            </div>
            <div class="card-body">
                <div class="progress mb-4">
                    <div id="progressBar" class="progress-bar bg-success" role="progressbar" style="width: 33%;"
                        aria-valuenow="33" aria-valuemin="0" aria-valuemax="100" data-step="Step 1 of 3"></div>
                </div>
                <form id="registrationForm" method="POST" enctype="multipart/form-data">
                    <div class="step active" id="step1">
                        <h5><i class="bi bi-person step-icon"></i> Personal Information</h5>
                        <div class="mb-3">
                            <div class="profile-container">
                                <div class="profile-placeholder" id="profilePlaceholder">+</div>
                                <img id="profilePic" alt="Profile picture" class="profile-pic">
                                <input type="file" id="profileImage" name="profileImage" accept="image/*"
                                    onchange="previewImage(event)">
                            </div>
                            <label for="firstName" class="form-label mt-3">First Name</label>
                            <input type="text" class="form-control" id="firstName" name="first_name" required
                                placeholder="Name">
                        </div>
                        <div class="mb-3">
                            <label for="lastName" class="form-label">Last Name</label>
                            <input type="text" class="form-control" id="lastName" name="last_name" required
                                placeholder="Last name">
                        </div>
                    </div>

                    <div class="step" id="step2">
                        <h5><i class="bi bi-envelope step-icon"></i> Contact Information</h5>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required
                                placeholder="Email">
                        </div>
                        <div class="mb-3">
                            <label for="phone" class="form-label">Phone</label>
                            <input type="tel" class="form-control" id="phone" name="phone" required placeholder="Phone">
                        </div>
                    </div>

                    <div class="step" id="step3">
                        <h5><i class="bi bi-shield-lock step-icon"></i> City Information</h5>
                        <div class="mb-3">
                            <label for="city" class="form-label">City</label>
                            <input type="text" class="form-control" id="city" name="city" required placeholder="City">
                        </div>
                    </div>

                    <div class="step-buttons">
                        <button type="button" class="btn btn-secondary" id="prevBtn" onclick="changeStep(-1)"
                            disabled>Previous</button>
                        <button type="button" class="btn btn-primary" id="nextBtn"
                            onclick="validateStep()">Next</button>
                        <button type="submit" class="btn btn-success d-none" id="submitBtn">Submit</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script>
        let currentStep = 1;

        function validateStep() {
            const currentStepFields = document.querySelectorAll(`.step:nth-child(${currentStep}) input`);
            let isValid = true;
            currentStepFields.forEach(field => {
                if (!field.checkValidity()) {
                    isValid = false;
                    field.classList.add("is-invalid");
                } else {
                    field.classList.remove("is-invalid");
                }
            });

            if (isValid) {
                changeStep(1);
            }
        }

        function changeStep(step) {
            const totalSteps = 3;
            const steps = document.querySelectorAll('.step');
            steps[currentStep - 1].classList.remove('active');
            currentStep += step;
            steps[currentStep - 1].classList.add('active');

            document.getElementById('prevBtn').disabled = currentStep === 1;
            document.getElementById('nextBtn').classList.toggle('d-none', currentStep === totalSteps);
            document.getElementById('submitBtn').classList.toggle('d-none', currentStep !== totalSteps);

            const progressBar = document.getElementById('progressBar');
            const progress = (currentStep / totalSteps) * 100;
            progressBar.style.width = progress + '%';
            progressBar.setAttribute('aria-valuenow', progress);
            progressBar.setAttribute('data-step', `Step ${currentStep} of ${totalSteps}`);
        }

        function previewImage(event) {
            const reader = new FileReader();
            reader.onload = function () {
                const output = document.getElementById('profilePic');
                const placeholder = document.getElementById('profilePlaceholder');

                output.src = reader.result;
                output.style.display = 'block';
                placeholder.style.display = 'none';
            };
            if (event.target.files[0]) {
                reader.readAsDataURL(event.target.files[0]);
            }
        }
    </script>
</body>

</html>