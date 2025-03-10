<?php
// Database connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "petstore";

$memberData = null;
$error = null;

try {
    $pdo = new PDO("mysql:host=$servername;dbname=$dbname", $username, $password);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
    // You'll need to implement proper authentication to get the current user's ID
    //$memberId = $_SESSION['member_id'] ?? 1; // Replace with proper authentication
    $memberId = 1;
    $stmt = $pdo->prepare("SELECT * FROM `reward_members` WHERE MemberID = ?");
    $stmt->execute([$memberId]);
    $memberData = $stmt->fetch(PDO::FETCH_ASSOC);
    
} catch(PDOException $e) {
    $error = 'Database error: ' . $e->getMessage();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fudge Rewards Program</title>
    <link
      href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
      rel="stylesheet"
    />
    <style>
      body {
        font-family: "Poppins", sans-serif;
        margin: 0;
        padding: 0;
        background-color: #f7f7f7;
        color: #333;
      }
      .container {
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
      }
      header {
        background-color: #ff6b4a;
        color: white;
        text-align: center;
        padding: 20px 0;
        position: relative;
        overflow: hidden;
      }
      header::before {
        content: "";
        position: absolute;
        top: -50%;
        left: -50%;
        width: 200%;
        height: 200%;
        background: radial-gradient(
          circle,
          rgba(255, 255, 255, 0.2) 0%,
          rgba(255, 255, 255, 0) 70%
        );
        animation: pulse 4s infinite;
      }
      @keyframes pulse {
        0% {
          transform: scale(1);
        }
        50% {
          transform: scale(1.1);
        }
        100% {
          transform: scale(1);
        }
      }
      h1 {
        margin: 0;
        font-size: 2.5em;
        position: relative;
      }
      .rewards-info {
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        margin-top: 30px;
        padding: 30px;
        display: flex;
        justify-content: space-between;
        align-items: center;
      }
      .member-info,
      .points-info {
        flex: 1;
      }
      .points-circle {
        width: 200px;
        height: 200px;
        background: linear-gradient(135deg, #ff6b4a, #ff8c6a);
        border-radius: 50%;
        display: flex;
        flex-direction: column;
        justify-content: center;
        align-items: center;
        color: white;
        margin: 0 auto;
        box-shadow: 0 10px 20px rgba(255, 107, 74, 0.3);
        transition: transform 0.3s ease;
      }
      .points-circle:hover {
        transform: scale(1.05);
      }
      .points-number {
        font-size: 3em;
        font-weight: bold;
      }
      .tier-progress {
        width: 80%;
        height: 10px;
        background-color: #e0e0e0;
        border-radius: 5px;
        margin-top: 20px;
        overflow: hidden;
      }
      .tier-progress-bar {
        height: 100%;
        background-color: #ff6b4a;
        width: 0;
        transition: width 1s ease-in-out;
      }
      .benefits {
        margin-top: 30px;
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 30px;
      }
      .benefit-item {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        transition: transform 0.3s ease;
      }
      .benefit-item:hover {
        transform: translateX(10px);
      }
      .benefit-icon {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, #ff6b4a, #ff8c6a);
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 20px;
        box-shadow: 0 5px 15px rgba(255, 107, 74, 0.3);
      }
      .benefit-icon img {
        width: 35px;
        height: 35px;
      }
      .how-it-works {
        margin-top: 30px;
        text-align: center;
      }
      .steps {
        display: flex;
        justify-content: space-around;
        margin-top: 20px;
      }
      .step {
        flex: 1;
        padding: 20px;
        background-color: white;
        border-radius: 15px;
        margin: 0 10px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        transition: transform 0.3s ease, box-shadow 0.3s ease;
      }
      .step:hover {
        transform: translateY(-5px);
        box-shadow: 0 15px 35px rgba(0, 0, 0, 0.2);
      }
      .step-number {
        font-size: 2em;
        font-weight: bold;
        color: #ff6b4a;
      }
      .rewards-tiers {
        margin-top: 30px;
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 30px;
      }
      .tier {
        display: flex;
        align-items: center;
        margin-bottom: 20px;
        padding: 15px;
        border-radius: 10px;
        transition: background-color 0.3s ease;
      }
      .tier:hover {
        background-color: #fff5f2;
      }
      .tier-icon {
        width: 50px;
        height: 50px;
        margin-right: 20px;
      }
      .tier-info {
        flex-grow: 1;
      }
      .tier-name {
        font-weight: bold;
        font-size: 1.2em;
        margin-bottom: 5px;
      }
      .tier-benefits {
        font-size: 0.9em;
        color: #666;
      }
      .recent-activity {
        margin-top: 30px;
        background-color: white;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
        padding: 30px;
      }
      .activity-item {
        display: flex;
        align-items: center;
        margin-bottom: 15px;
        padding-bottom: 15px;
        border-bottom: 1px solid #eee;
      }
      .activity-icon {
        width: 40px;
        height: 40px;
        background-color: #ff6b4a;
        border-radius: 50%;
        display: flex;
        justify-content: center;
        align-items: center;
        margin-right: 15px;
      }
      .activity-icon img {
        width: 20px;
        height: 20px;
      }
      .activity-details {
        flex-grow: 1;
      }
      .activity-date {
        font-size: 0.8em;
        color: #999;
      }
    </style>
  </head>
<body>
    <header>
      <div class="container">
        <h1>Fudge Rewards Program</h1>
      </div>
    </header>

    <div class="container">
      <?php if ($error): ?>
        <div class="error-message">
            <?php echo htmlspecialchars($error); ?>
        </div>
      <?php elseif ($memberData): ?>
        <div class="rewards-info">
            <div class="member-info">
                <h2>Member Information</h2>
                <p><strong>Email:</strong> <?php echo htmlspecialchars($memberData['Email']); ?></p>
                <p><strong>Address:</strong> 
                    <?php 
                    echo htmlspecialchars($memberData['Address_Line1']);
                    if ($memberData['Address_Line2']) {
                        echo ', ' . htmlspecialchars($memberData['Address_Line2']);
                    }
                    echo ', ' . htmlspecialchars($memberData['City']);
                    echo ', ' . htmlspecialchars($memberData['State']);
                    echo ' ' . htmlspecialchars($memberData['Zip']);
                    ?>
                </p>
                <p><strong>Visits:</strong> <?php echo htmlspecialchars($memberData['Visits']); ?></p>
            </div>
            <div class="points-info">
                <div class="points-circle">
                    <div class="points-number" id="reward-points">0</div>
                    <div>POINTS</div>
                </div>
                <div class="tier-progress">
                    <div class="tier-progress-bar" id="tier-progress"></div>
                </div>
                <p>Silver Tier - 250 points to Gold</p>
            </div>
        </div>

        <script>
            const memberPoints = <?php echo (isset($memberData['Rewards']) ? (int)$memberData['Rewards'] : 0); ?>;

            document.addEventListener('DOMContentLoaded', function() {
                const rewardPoints = document.getElementById("reward-points");
                const duration = 2000;
                const startValue = 0;
                const endValue = memberPoints;

                let startTimestamp = null;
                const step = (timestamp) => {
                    if (!startTimestamp) startTimestamp = timestamp;
                    const progress = Math.min((timestamp - startTimestamp) / duration, 1);
                    const currentValue = Math.floor(progress * (endValue - startValue) + startValue);
                    rewardPoints.textContent = currentValue;
                    
                    if (progress < 1) {
                        window.requestAnimationFrame(step);
                    }
                };
                window.requestAnimationFrame(step);

                const tierProgressBar = document.getElementById("tier-progress");
                const progressPercentage = ((memberPoints % 250) / 250) * 100;
                setTimeout(() => {
                    tierProgressBar.style.width = `${progressPercentage}%`;
                }, 500);
            });
        </script>
      <?php else: ?>
        <div class="error-message">
            Member not found.
        </div>
      <?php endif; ?>

      <div class="rewards-tiers">
        <h2>Rewards Tiers</h2>
        <div class="tier">
          <img
            src="https://png.pngtree.com/png-vector/20191212/ourmid/pngtree-third-place-bronze-medal-for-sport-podium-winner-png-image_2050412.jpg"
            alt="Bronze tier"
            class="tier-icon"
          />
          <div class="tier-info">
            <div class="tier-name">Bronze</div>
            <div class="tier-benefits">5% discount on all purchases</div>
          </div>
        </div>
        <div class="tier">
          <img
            src="https://png.pngtree.com/png-vector/20191212/ourmid/pngtree-second-place-silver-medal-for-sport-podium-winner-png-image_2050419.jpg"
            alt="Silver tier"
            class="tier-icon"
          />
          <div class="tier-info">
            <div class="tier-name">Silver</div>
            <div class="tier-benefits">
              10% discount on all purchases, free shipping
            </div>
          </div>
        </div>
        <div class="tier">
          <img
            src="https://img.icons8.com/color/48/000000/gold-medal.png"
            alt="Gold tier"
            class="tier-icon"
          />
          <div class="tier-info">
            <div class="tier-name">Gold</div>
            <div class="tier-benefits">
              15% discount on all purchases, free shipping, exclusive products
            </div>
          </div>
        </div>
      </div>

      <div class="benefits">
        <h2>Your Rewards Benefits</h2>
        <div class="benefit-item">
          <div class="benefit-icon">
            <img
              src="https://img.icons8.com/ios-filled/50/ffffff/discount--v1.png"
              alt="Discount icon"
            />
          </div>
          <div>
            <h3>Exclusive Discounts</h3>
            <p>Get special discounts on selected items every month.</p>
          </div>
        </div>
        <div class="benefit-item">
          <div class="benefit-icon">
            <img
              src="https://img.icons8.com/ios-filled/50/ffffff/gift--v1.png"
              alt="Gift icon"
            />
          </div>
          <div>
            <h3>Birthday Treats</h3>
            <p>Receive a special gift on your birthday!</p>
          </div>
        </div>
        <div class="benefit-item">
          <div class="benefit-icon">
            <img
              src="https://img.icons8.com/ios-filled/50/ffffff/fast-cart.png"
              alt="Fast cart icon"
            />
          </div>
          <div>
            <h3>Early Access</h3>
            <p>Shop new collections before anyone else.</p>
          </div>
        </div>
      </div>

      <div class="recent-activity">
        <h2>Recent Activity</h2>
        <div class="activity-item">
          <div class="activity-icon">
            <img
              src="https://img.icons8.com/ios-filled/50/ffffff/shopping-bag.png"
              alt="Purchase icon"
            />
          </div>
          <div class="activity-details">
            <div>Earned 50 points from purchase</div>
            <div class="activity-date">May 15, 2023</div>
          </div>
        </div>
        <div class="activity-item">
          <div class="activity-icon">
            <img
              src="https://img.icons8.com/ios-filled/50/ffffff/gift.png"
              alt="Redeem icon"
            />
          </div>
          <div class="activity-details">
            <div>Redeemed 100 points for discount</div>
            <div class="activity-date">May 10, 2023</div>
          </div>
        </div>
      </div>

      <div class="how-it-works">
        <h2>How It Works</h2>
        <div class="steps">
          <div class="step">
            <div class="step-number">1</div>
            <h3>Shop</h3>
            <p>Make purchases at Fudge</p>
          </div>
          <div class="step">
            <div class="step-number">2</div>
            <h3>Earn</h3>
            <p>Get 1 point for every ₹100 spent</p>
          </div>
          <div class="step">
            <div class="step-number">3</div>
            <h3>Redeem</h3>
            <p>Use your points for discounts and perks</p>
          </div>
        </div>
      </div>
    </div>
  </body>
</html>
