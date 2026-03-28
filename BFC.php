<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Body Fat Percentage Calculator</title>
    <link rel="icon" type="image/x-icon" href=".\images\keepfit-favicon-color.png">
    <link rel="stylesheet" href=".\styles\BFC.css">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
</head>

<body>

    <div class="Meniu">
        <div id="imgdis">
            <div style="display:flex; align-items:center;" class="logo-container">
                <a href="index.html"><img src=".\images\logo simplu\png\logo-no-background.png" alt="Logo"
                        class="img_logo_meniu"></a>
            </div>
            <div>
                <a href="\KeepFit\start.php" class="Discover-container">
                    <p>Home</p>
                </a>
            </div>
        </div>
    </div>
    <h1>Body Fat Percentage Calculator</h1>
    <div style="display:flex; justify-content:center;">
        <form id="bfp-form">
            <label for="gender">Gender:</label>
            <select id="gender">
                <option value="male">Male</option>
                <option value="female">Female</option>
            </select>

            <label for="measurement-system">Measurement System:</label>
            <select id="measurement-system" onchange="changeSystem()">
                <option value="metric">Metric (cm, kg)</option>
                <option value="usc">USC (in, lb)</option>
            </select>

            <div id="metric-inputs">
                <label for="waist-metric">Waist (cm):</label>
                <input type="number" id="waist-metric" required>

                <label for="hip-metric">Hip (cm): <em>(only for females)</em></label>
                <input type="number" id="hip-metric" required>

                <label for="neck-metric">Neck (cm):</label>
                <input type="number" id="neck-metric" required>

                <label for="height-metric">Height (cm):</label>
                <input type="number" id="height-metric" required>

                <label for="weight-metric">Weight (kg):</label>
                <input type="number" id="weight-metric" required>
            </div>

            <div id="usc-inputs" style="display: none;">
                <label for="waist-usc">Waist (in):</label>
                <input type="number" id="waist-usc" required>

                <label for="hip-usc">Hip (in): <em>(only for females)</em></label>
                <input type="number" id="hip-usc" required>

                <label for="neck-usc">Neck (in):</label>
                <input type="number" id="neck-usc" required>

                <label for="height-usc">Height (in):</label>
                <input type="number" id="height-usc" required>

                <label for="weight-usc">Weight (lb):</label>
                <input type="number" id="weight-usc" required>
            </div>

            <button type="button" onclick="calculateBFP()">Calculate</button>
        </form>
    </div>
    <h2 id="result"></h2>

    <script>
        function changeSystem() {
            const system = document.getElementById('measurement-system').value;
            if (system === 'metric') {
                document.getElementById('metric-inputs').style.display = 'block';
                document.getElementById('usc-inputs').style.display = 'none';
            } else {
                document.getElementById('metric-inputs').style.display = 'none';
                document.getElementById('usc-inputs').style.display = 'block';
            }
        }
        function calculateBFP() {
            const gender = document.getElementById('gender').value;
            const system = document.getElementById('measurement-system').value;
            var waist, hip, neck, height, weight, bfp;

            if (system === 'metric') {
                waist = document.getElementById('waist-metric').value;
                hip = document.getElementById('hip-metric').value;
                neck = document.getElementById('neck-metric').value;
                height = document.getElementById('height-metric').value;
                weight = document.getElementById('weight-metric').value;
            } else {
                waist = document.getElementById('waist-usc').value;
                hip = document.getElementById('hip-usc').value;
                neck = document.getElementById('neck-usc').value;
                height = document.getElementById('height-usc').value;
                weight = document.getElementById('weight-usc').value;
            }

            if (!waist || !neck || !height || !weight || (gender === 'female' && !hip)) {
                document.getElementById('result').innerHTML = 'Please fill in all required fields to calculate the body fat percentage.';
                return;
            }

            waist = parseFloat(waist);
            hip = parseFloat(hip);
            neck = parseFloat(neck);
            height = parseFloat(height);
            weight = parseFloat(weight);

            if (system === 'metric') {
                bfp = gender === 'male' ?
                    (495 / (1.0324 - 0.19077 * Math.log10(waist - neck) + 0.15456 * Math.log10(height)) - 450) :
                    (495 / (1.29579 - 0.35004 * Math.log10(waist + hip - neck) + 0.22100 * Math.log10(height)) - 450);
            } else {
                bfp = gender === 'male' ?
                    (86.010 * Math.log10(waist - neck) - 70.041 * Math.log10(height) + 36.76) :
                    (163.205 * Math.log10(waist + hip - neck) - 97.684 * Math.log10(height) - 78.387);
            }

            var fatMass = (bfp / 100) * weight;
            var leanMass = weight - fatMass;

            document.getElementById('result').innerHTML = 'Body Fat Percentage: ' + bfp.toFixed(2) + '%<br>' +
                'Fat Mass: ' + fatMass.toFixed(2) + ' ' + (system === 'metric' ? 'kg' : 'lbs') + '<br>' +
                'Lean Mass: ' + leanMass.toFixed(2) + ' ' + (system === 'metric' ? 'kg' : 'lbs');
        }
    </script>

</body>

</html>