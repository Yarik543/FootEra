<?php
/* ===== DB CONNECTION ===== */
$host = "localhost";
$user = "kasimbekov_yaroslav_FootEra";
$password = "!KasYarik2!"; // 
$dbname = "kasimbekov_yaroslav_FootEra";

$conn = new mysqli($host, $user, $password, $dbname);
$conn->set_charset("utf8");

/* ===== MATCHES ===== */
$sqlMatches = "
SELECT 
  m.MatchId,
  m.MatchDate,
  m.HomeGoals,
  m.AwayGoals,
  m.Stadium,

  ht.Name AS HomeTeam,
  ht.Logo AS HomeLogo,

  at.Name AS AwayTeam,
  at.Logo AS AwayLogo

FROM Matches m
JOIN Teams ht ON ht.TeamId = m.HomeTeamId
JOIN Teams at ON at.TeamId = m.AwayTeamId

ORDER BY m.MatchDate DESC
LIMIT 5
";

$resultMatches = $conn->query($sqlMatches);
$matches = [];

while ($row = $resultMatches->fetch_assoc()) {
  $matches[] = $row;
}

if ($conn->connect_error) {
  die("Ошибка подключения: " . $conn->connect_error);
}

/* ===== TOP-7 TEAMS ===== */
$sql = "
SELECT 
  t.TeamId,
  t.Name,
  t.Logo,
  ts.Points
FROM TeamStats ts
JOIN Teams t ON t.TeamId = ts.TeamId
WHERE ts.Season = '2015/2016'
ORDER BY ts.Points DESC
LIMIT 7
";

$result = $conn->query($sql);
$teams = [];

$position = 1;
while ($row = $result->fetch_assoc()) {
  $row['Position'] = $position;
  $teams[] = $row;
  $position++;
}
?>
<!DOCTYPE html>
<html lang="ru">
<head>
  <meta charset="UTF-8">
  <title>FootEra — La Liga 2015/16</title>

  <link rel="stylesheet" href="style.css?v=<?= filemtime('style.css') ?>">
  <link href="https://fonts.googleapis.com/css2?family=Oswald:wght@300;500;600&family=Inter:wght@400;500&display=swap" rel="stylesheet">

</head>

<body>

<!-- ===== HEADER ===== -->
<header class="header">
  <div class="container header-inner">
    <div class="logo">FootEra</div>

    <nav class="nav">
      <a class="active" href="#">Главная</a>
      <a href="#footer">Контакты</a>
    </nav>

    <img class="logo-header" src="/image/logo.jpg" alt="logo">
  </div>
</header>

<!-- ===== HERO ===== -->
<section class="hero">
  <div class="hero-overlay"></div>
  <div class="container hero-grid">

    <div class="hero-menu">
      <a href="#">Новости</a>
      <a href="#">Команды</a>
      <a href="#">Матчи</a>
      <a href="#">Рекорды</a>
    </div>

    <div class="hero-content">
      <h1>Ла Лига 2015/2016<br>
        <span>сезон, который вошёл в историю</span>
      </h1>

      <p>
        Главные события, рекорды и противостояния легендарного сезона.
      </p>

      <a href="#" class="hero-btn">Смотреть матчи</a>
    </div>

  </div>
</section>

<!-- ===== TOP 7 ===== -->
<section class="top7">
  <div class="container top7-grid">

    <!-- LEFT LIST -->
    <div class="top7-list">
      <h3>Топ-7 La Liga 2015/2016</h3>

      <?php foreach ($teams as $index => $team): ?>
  <div class="top7-row <?= $index === 0 ? 'active' : '' ?>"
       data-logo="<?= $team['Logo'] ?>"
       data-points="<?= $team['Points'] ?>">
    <span><?= $team['Position'] ?></span>
    <p><?= $team['Name'] ?></p>
  </div>
<?php endforeach; ?>
    </div>

    <!-- RIGHT CONTENT -->
    <?php if (!empty($teams)): ?>
    <div class="top7-content" id="top7-content">

      <div class="team-logo">
          <img id="team-logo-img"
          src="/team-logo/<?= $teams[0]['Logo'] ?>"
          alt="<?= $teams[0]['Name'] ?>">
      </div>

      <h2 id="team-name"><?= $teams[0]['Name'] ?></h2>
      <p id="team-info">
        <?= $teams[0]['Position'] ?> место · <?= $teams[0]['Points'] ?> очков
      </p>

      <div class="top7-arrows">
  <span class="arrow prev">&lt;</span>
  <span class="arrow next">&gt;</span>
</div>

    </div>
    <?php endif; ?>

  </div>
</section>

<section class="records">
  <div class="container">
    <h2 class="records-title">Сезонные рекорды La Liga 2015/2016</h2>
    <p class="records-subtitle">Самые яркие достижения игроков и команд</p>

  <div class="records-stats">
  <div class="records-stat">
    <span class="stat-icon">🏆</span>
    <div>
      <strong>Лучший бомбардир</strong>
      <p>Luis Suárez · 40 голов</p>
    </div>
  </div>

  <div class="records-stat">
    <span class="stat-icon">🎯</span>
    <div>
      <strong>Лидер по ассистам</strong>
      <p>Lionel Messi · 16 передач</p>
    </div>
  </div>

  <div class="records-stat">
    <span class="stat-icon">🛡️</span>
    <div>
      <strong>Лучшая оборона</strong>
      <p>Atlético Madrid · 18 пропущенных</p>
    </div>
  </div>
</div>

  <div class="records-slider-wrapper">
  <div class="container records-container">
    <div class="records-viewport">
      <div class="records-track">

        <div class="record-card">
        <img src="/players-record-image/godin3.jpg">
        <span>Лучший защитник сезона</span>
        <h4>Diego Godín</h4>
      </div>

      <div class="record-card">
        <img src="/players-record-image/oblac_mask.jpg">
        <span>0.47 GA — лучшая оборона сезона</span>
        <h4>Jan Oblak</h4>
      </div>

      <div class="record-card">
        <img src="/players-record-image/neymar.jpg">
        <span>164 успешные обводки — лучший дриблёр</span>
        <h4>Neymar Jr</h4>
      </div>

      <div class="record-card">
        <img src="/players-record-image/modric_mask.jpg">
        <span>90.5% точных передач — лидер по пасам</span>
        <h4>Luka Modrić</h4>
      </div>

      <div class="record-card">
        <img src="/players-record-image/Carrasco.jpg">
        <span>Самый быстрый <br> гол сезона — 1:22</span>
        <h4>Yannick Carrasco</h4>

          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<section class="matches">
  <div class="container">

    <div class="matches-header">
      <h2>Ключевые матчи сезона</h2>
      <p>Матчи, которые определили исход Ла Лиги 2015/2016</p>
    </div>

    <div class="matches-slider">
      <div class="matches-cards">

        <?php foreach ($matches as $i => $match): ?>
          <div class="match-card <?= $i === 0 ? 'active' : '' ?>">

            <!-- ЛЕВАЯ ЧАСТЬ -->
            <div class="match-left">
              <span class="match-date">
                <?= date("d.m.Y", strtotime($match['MatchDate'])) ?>
              </span>

              <h3 class="match-teams">
                <?= $match['HomeTeam'] ?> — <?= $match['AwayTeam'] ?>
              </h3>

              <div class="match-score">
                <img src="team-logo/<?= $match['HomeLogo'] ?>" alt="">
                <strong><?= $match['HomeGoals'] ?> : <?= $match['AwayGoals'] ?></strong>
                <img src="team-logo/<?= $match['AwayLogo'] ?>" alt="">
              </div>

              <!-- СТАДИОН ПО ЦЕНТРУ -->
              <div class="match-stadium">
                <span>🏟 Стадион</span>
                <p><?= $match['Stadium'] ?></p>
              </div>
            </div>

            <!-- ПРАВАЯ ЧАСТЬ -->
            <div class="match-right">

              <!-- СТАТИСТИКА (НЕ ИЗ БД) -->
              <div class="match-stats">
                <div>
                  <strong>56%</strong>
                  <span>Владение</span>
                  <strong>44%</strong>
                </div>
                <div>
                  <strong>15</strong>
                  <span>Удары</span>
                  <strong>10</strong>
                </div>
              </div>

              <!-- РАЗНОЕ ОПИСАНИЕ -->
              <p class="match-desc">
                <?php
                  $descs = [
                    "Матч с высокой интенсивностью, в котором исход решился во втором тайме.",
                    "Тактическое противостояние, где одна ошибка стоила сопернику очков.",
                    "Один из самых напряжённых матчей сезона с драматичной концовкой.",
                    "Равная игра, в которой ключевую роль сыграли стандарты.",
                    "Матч, укрепивший позиции лидера в чемпионской гонке."
                  ];
                  echo $descs[$i % count($descs)];
                ?>
              </p>

              <a href="#" class="match-btn">Смотреть обзор</a>
            </div>

          </div>
        <?php endforeach; ?>

      </div>

      <!-- СТРЕЛКИ -->
      <div class="matches-arrows">
        <span class="match-arrow prev">&#10094;</span>
        <span class="match-arrow next">&#10095;</span>
      </div>
    </div>

  </div>
</section>

<section class="season-news">
  <div class="container">

    <div class="section-header">
      <h2>Главные новости сезона</h2>
    </div>

    <div class="news-list">

  <div class="news-card">
    <div class="news-image"><img src="/image/barca1.jpg" alt = "barca"></div>

    <div class="news-content">
      <h3>Барселона выходит на первое место</h3>
      <span class="news-date">20 марта 2016</span>

      <div class="news-more">
        <p>
          Каталонцы одержали важную победу в концовке сезона,
          которая позволила команде выйти в лидеры чемпионата.
          Матч стал переломным моментом в чемпионской гонке.
        </p>
      </div>
    </div>

    <button class="news-btn">Читать</button>
  </div>

  <div class="news-card">
    <div class="news-image"><img src="/image/real.jpg" alt="real"></div>

    <div class="news-content">
      <h3>Реал теряет очки в выездном матче</h3>
      <span class="news-date">3 апреля 2016</span>

      <div class="news-more">
        <p>
          Неожиданная осечка мадридского клуба позволила конкурентам
          сократить отставание в турнирной таблице.
        </p>
      </div>
    </div>

    <button class="news-btn">Читать</button>
  </div>

  <div class="news-card">
    <div class="news-image"><img src="/image/atletic.jpg" alt = "atletic"></div>
                  
    <div class="news-content">
      <h3>Атлетико продолжает погоню за лидерами</h3>
      <span class="news-date">10 апреля 2016</span>

      <div class="news-more">
        <p>
          Команда Симеоне демонстрирует стабильную форму
          и остаётся в борьбе за чемпионство.
        </p>
      </div>
    </div>

    <button class="news-btn">Читать</button>
  </div>

</div>
</section>

<!-- ===== DATA FOR JS ===== -->
<script>
const teams = <?= json_encode($teams, JSON_UNESCAPED_UNICODE); ?>;
</script>

<script src="top7.js"></script>
<script src="records.js"></script>
<script src="matches.js"></script>
<script src="news.js"></script>

</body>
</html>