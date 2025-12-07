<!-- Modern Dashboard Redesign -->
<link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
<style>
  /* body, .main-inner, .container { font-family: 'Roboto', Arial, sans-serif; background: #f4f6fb; } */
  .dashboard-header {
    background: linear-gradient(90deg, #1976d2 0%, #64b5f6 100%);
    color: #fff;
    padding: 32px 24px 24px 24px;
    border-radius: 18px;
    margin-bottom: 32px;
    box-shadow: 0 4px 24px rgba(33,150,243,0.08);
    display: flex; align-items: center; justify-content: space-between;
  }
  .dashboard-header h1 { font-size: 2.2rem; margin: 0; font-weight: 700; }
  .dashboard-header .welcome { font-size: 1.1rem; opacity: 0.85; }
  .dashboard-cards { display: flex; gap: 32px; flex-wrap: wrap; }
  .dashboard-card {
    background: #fff;
    border-radius: 16px;
    box-shadow: 0 2px 12px rgba(33,150,243,0.07);
    padding: 28px 24px;
    flex: 1 1 340px;
    min-width: 340px;
    margin-bottom: 32px;
    transition: box-shadow 0.2s;
    position: relative;
  }
  .dashboard-card:hover { box-shadow: 0 6px 24px rgba(33,150,243,0.13); }
  .dashboard-card .card-title {
    font-size: 1.3rem;
    font-weight: 600;
    margin-bottom: 18px;
    color: #1976d2;
    display: flex; align-items: center;
    gap: 10px;
  }
  .dashboard-card .card-actions { margin-top: 18px; display: flex; flex-wrap: wrap; gap: 12px; }
  .dashboard-card .shortcut {
    display: flex; align-items: center; gap: 8px;
    background: linear-gradient(90deg, #e3f2fd 0%, #bbdefb 100%);
    color: #1976d2;
    border-radius: 8px;
    padding: 10px 18px;
    font-weight: 500;
    text-decoration: none;
    box-shadow: 0 1px 4px rgba(33,150,243,0.07);
    transition: background 0.2s;
  }
  .dashboard-card .shortcut:hover {
    background: linear-gradient(90deg, #1976d2 0%, #64b5f6 100%);
    color: #fff;
  }
  .dashboard-card .shortcut-icon {
    font-size: 1.3rem;
    color: #1976d2;
    transition: color 0.2s;
  }
  .dashboard-card .shortcut:hover .shortcut-icon { color: #fff; }
  .dashboard-card .card-chart {
    margin-top: 18px;
    background: #f4f6fb;
    border-radius: 12px;
    padding: 12px;
    box-shadow: 0 1px 6px rgba(33,150,243,0.05);
  }
  @media (max-width: 900px) {
    .dashboard-cards { flex-direction: column; gap: 0; }
    .dashboard-card { min-width: unset; margin-bottom: 24px; }
  }
</style>

<div class="main">
  <div class="main-inner">
    <div class="container">
      <div class="dashboard-header">
        <div>
          <h1><i class="icon-dashboard" style="margin-right:12px;"></i>ERP Dashboard</h1>
          <div class="welcome">Welcome, <strong><?php echo $this->session->userdata('identity'); ?></strong>! Here is your business overview.</div>
        </div>
        <div style="font-size:1.5rem;opacity:0.7;"><i class="icon-bar-chart"></i></div>
      </div>
      <div class="dashboard-cards">
        <div class="dashboard-card">
          <div class="card-title"><i class="icon-bookmark"></i> Important Shortcuts</div>
          <div class="card-actions">
<?php
  $sesdata = $this->session->userdata;
  $group = $sesdata['group'];
  $menus = $this->common_model->get_menu($group);
?>
<?php if($group==1){ ?>
<a href="<?php echo site_url('admin/production/adminproduction')?>" class="shortcut"><i class="shortcut-icon icon-list-alt"></i>VIEW PRODUCTION</a>
<a href="<?php echo site_url('admin/sales/admin_sales')?>" class="shortcut"><i class="shortcut-icon icon-list-alt"></i>VIEW SALES</a>
<a href="<?php echo site_url('admin/stock')?>" class="shortcut"><i class="shortcut-icon icon-list-alt"></i>VIEW STOCK</a>
<a href="<?php echo site_url('admin/account/view_account')?>" class="shortcut"><i class="shortcut-icon icon-list-alt"></i>VIEW PURCHASE</a>
<a href="<?php echo site_url('admin/sales/summery')?>" class="shortcut"><i class="shortcut-icon icon-list-alt"></i>SALES SUMMERY</a>
<a href="<?php echo site_url('admin/sales/report')?>" class="shortcut"><i class="shortcut-icon icon-list-alt"></i>SALES REPORT</a>
<a href="<?php echo site_url('admin/account/report')?>" class="shortcut"><i class="shortcut-icon icon-list-alt"></i>PURCHASE REPORT</a>
<?php } ?>
<?php if($group==2){ ?>
<a href="<?php echo site_url('admin/production')?>" class="shortcut"><i class="shortcut-icon icon-list-alt"></i>VIEW PRODUCTION</a>
<a href="<?php echo site_url('admin/sales/view_sales')?>" class="shortcut"><i class="shortcut-icon icon-list-alt"></i>VIEW SALES</a>
<a href="<?php echo site_url('admin/stock')?>" class="shortcut"><i class="shortcut-icon icon-list-alt"></i>VIEW STOCK</a>
<a href="<?php echo site_url('admin/account/view_account')?>" class="shortcut"><i class="shortcut-icon icon-list-alt"></i>VIEW PURCHASE</a>
<a href="<?php echo site_url('admin/sales/summery')?>" class="shortcut"><i class="shortcut-icon icon-list-alt"></i>SALES SUMMERY</a>
<a href="<?php echo site_url('admin/acount/report')?>" class="shortcut"><i class="shortcut-icon icon-list-alt"></i>PURCHASE SUMMERY</a>
<?php } ?>
          </div>
        </div>
        <div class="dashboard-card">
          <div class="card-title"><i class="icon-th-list"></i> Sales vs Collections</div>
          <div class="card-chart">
            <div id="barchart_material" style="height: 340px;"></div>
          </div>
        </div>
        <div class="dashboard-card">
          <div class="card-title"><i class="icon-industry"></i> Production Overview</div>
          <div class="card-chart">
            <div id="production_chart" style="height: 340px;"></div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Google Charts -->
<script type="text/javascript" src="https://www.gstatic.com/charts/loader.js"></script>
<script type="text/javascript">
  google.charts.load('current', {'packages':['bar']});
  google.charts.setOnLoadCallback(drawChart);
  google.charts.setOnLoadCallback(drawProductionChart);
  function drawChart() {
    var data = google.visualization.arrayToDataTable([
      ['date', 'Sales', 'Collection'],
      [<?php echo json_encode($data5['date']); ?>, <?php echo json_encode((float)$data5['sales']); ?>, <?php echo json_encode((float)$data5['colection']); ?>],
      [<?php echo json_encode($data4['date']); ?>, <?php echo json_encode((float)$data4['sales']); ?>, <?php echo json_encode((float)$data4['colection']); ?>],
      [<?php echo json_encode($data3['date']); ?>, <?php echo json_encode((float)$data3['sales']); ?>, <?php echo json_encode((float)$data3['colection']); ?>],
      [<?php echo json_encode($data2['date']); ?>, <?php echo json_encode((float)$data2['sales']); ?>, <?php echo json_encode((float)$data2['colection']); ?>],
      [<?php echo json_encode($data1['date']); ?>, <?php echo json_encode((float)$data1['sales']); ?>, <?php echo json_encode((float)$data1['colection']); ?>]
    ]);
    var options = {
      chart: {
        title: 'Sales vs Collections',
        subtitle: 'Last 5 Days',
      },
      bars: 'vertical',
      colors: ['#1976d2', '#43a047'],
      legend: { position: 'top', alignment: 'center' },
      backgroundColor: { fill: '#f4f6fb' },
      vAxis: { gridlines: { color: '#e3f2fd' } },
      hAxis: { textStyle: { color: '#1976d2', fontSize: 13 } }
    };
    var chart = new google.charts.Bar(document.getElementById('barchart_material'));
    chart.draw(data, google.charts.Bar.convertOptions(options));
  }
  function drawProductionChart() {
    var data = google.visualization.arrayToDataTable([
      ['Date', 'Production'],
      [<?php echo json_encode(isset($prod5['date']) && $prod5['date'] !== null ? (string)$prod5['date'] : ''); ?>, <?php echo (float)($prod5['amount'] ?? 0); ?>],
      [<?php echo json_encode(isset($prod4['date']) && $prod4['date'] !== null ? (string)$prod4['date'] : ''); ?>, <?php echo (float)($prod4['amount'] ?? 0); ?>],
      [<?php echo json_encode(isset($prod3['date']) && $prod3['date'] !== null ? (string)$prod3['date'] : ''); ?>, <?php echo (float)($prod3['amount'] ?? 0); ?>],
      [<?php echo json_encode(isset($prod2['date']) && $prod2['date'] !== null ? (string)$prod2['date'] : ''); ?>, <?php echo (float)($prod2['amount'] ?? 0); ?>],
      [<?php echo json_encode(isset($prod1['date']) && $prod1['date'] !== null ? (string)$prod1['date'] : ''); ?>, <?php echo (float)($prod1['amount'] ?? 0); ?>]
    ]);
    var options = {
      chart: {
        title: 'Production Overview',
        subtitle: 'Last 5 Days',
      },
      bars: 'vertical',
      colors: ['#ff9800'],
      legend: { position: 'none' },
      backgroundColor: { fill: '#f4f6fb' },
      vAxis: { gridlines: { color: '#e3f2fd' } },
      hAxis: { textStyle: { color: '#ff9800', fontSize: 13 } }
    };
    var chart = new google.charts.Bar(document.getElementById('production_chart'));
    chart.draw(data, google.charts.Bar.convertOptions(options));
  }
</script>
