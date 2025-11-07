<?php require_once('../assets/config/auth.php'); require_once('../assets/config/db.php'); ?>
<!DOCTYPE html><html lang="pt-BR"><head>
<meta charset="utf-8"><meta name="viewport" content="width=device-width, initial-scale=1">
<title>Relatórios - Vai de Trem</title>
<?php include '_partials/header.php'; ?>
</head><body>
<div class="container">
  <h2>Relatórios e Análises</h2>
  <div class="kpi">
    <div class="card pad"><div class="link-muted">Passageiros/Mês</div><div class="big">10.2K</div></div>
    <div class="card pad"><div class="link-muted">Viagens/Mês</div><div class="big">185</div></div>
    <div class="card pad"><div class="link-muted">Pontualidade</div><div class="big">94%</div></div>
    <div class="card pad"><div class="link-muted">Satisfação</div><div class="big">4.7</div></div>
  </div>
  <div class="grid cols-2" style="margin-top:14px">
    <div class="card pad"><strong>Passageiros e Viagens por Mês</strong><div class="link-muted">Últimos 6 meses (mock)</div>
      <img src="https://dummyimage.com/600x260/e9f2ff/1e66ff.png&text=Line+Chart+Mock" alt="chart" style="width:100%;border-radius:10px;margin-top:10px">
    </div>
    <div class="card pad"><strong>Distribuição por Rota</strong><div class="link-muted">Percentual de uso (mock)</div>
      <img src="https://dummyimage.com/420x260/e9f2ff/1e66ff.png&text=Pie+Chart+Mock" alt="chart" style="width:100%;border-radius:10px;margin-top:10px">
    </div>
  </div>
</div>
</body></html>
