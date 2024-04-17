<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Compatibility Check</title>
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Montserrat:400,800">
  <style>
    @import url('https://fonts.googleapis.com/css?family=Montserrat:400,800');

    * {
      box-sizing: border-box;
    }

    body {
      background: #f6f5f7;
      display: flex;
      justify-content: center;
      align-items: center;
      flex-direction: column;
      font-family: 'Montserrat', sans-serif;
      height: 33vh; /* One-third of the current height */
      margin: -20px 0 50px;
    }

    h2 {
      font-weight: bold;
      margin: 0;
    }

    form {
      background-color: #FF4B2B;
      display: flex;
      align-items: center;
      justify-content: center;
      flex-direction: column;
      padding: 20px;
      height: auto;
      text-align: center;
      border-radius: 10px;
      box-shadow: 0 14px 28px rgba(0,0,0,0.25), 
                  0 10px 10px rgba(0,0,0,0.22);
      width: 60%; /* Double the current width */
      overflow: hidden;
      position: relative;
    }

    input {
      background-color: #eee;
      border: none;
      padding: 12px 15px;
      margin: 8px 0;
      width: 100%;
    }

    label {
      color: #fff;
      margin: 15px 0;
    }

    .checkbox-container {
      display: flex;
      align-items: center;
      justify-content: center;
      margin: 15px 0;
    }

    .checkbox-label {
      color: #fff;
      margin-left: 5px;
    }

    button {
      border-radius: 20px;
      border: 1px solid #FF4B2B;
      background-color: #FF4B2B;
      color: #FFFFFF;
      font-size: 12px;
      font-weight: bold;
      padding: 12px 45px;
      letter-spacing: 1px;
      text-transform: uppercase;
      transition: transform 80ms ease-in, background-color 300ms ease-in-out;
      margin-top: 15px;
      cursor: pointer;
    }

    button:active {
      transform: scale(0.95);
    }

    button:focus {
      outline: none;
    }

    button.loading {
      background-color: #fff; /* White background during loading animation */
      color: #FF4B2B;
    }

    @keyframes slideDown {
      from {
        height: 0;
        opacity: 0;
      }
      to {
        height: 50px; /* Adjust height as needed */
        opacity: 1;
      }
    }
  </style>
</head>
<body>
  <h2>Compatibility Check</h2>
  <form id="compatibilityForm">
    <input type="text" name="input1" placeholder="Enter value for input 1" required>
    <input type="text" name="input2" placeholder="Enter value for input 2" required>
    
    <label>Choose Option:</label>
    <div class="checkbox-container">
      <input type="radio" name="option" id="option1" required>
      <label for="option1" class="checkbox-label">Option 1</label>
      
      <input type="radio" name="option" id="option2" required>
      <label for="option2" class="checkbox-label">Option 2</label>
    </div>
    
    <button type="button" onclick="submitForm()">Submit</button>
    <div id="loadingOverlay"></div>
  </form>

  <script>
    function submitForm() {
      const form = document.getElementById('compatibilityForm');
      const loadingOverlay = document.getElementById('loadingOverlay');

      // Add loading class to button
      document.querySelector('button').classList.add('loading');

      // Add slide down animation to loading overlay
      loadingOverlay.style.animation = 'slideDown 0.6s ease-in-out';

      // Simulate loading delay (remove this in a real scenario)
      setTimeout(() => {
        // Remove loading class and animation after delay
        document.querySelector('button').classList.remove('loading');
        loadingOverlay.style.animation = '';

        // You can add further actions or redirect after the loading is complete
        // Example: form.submit();
      }, 2000);
    }
  </script>
</body>
</html>
 