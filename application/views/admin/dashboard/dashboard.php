<!-- BEGIN: Content -->
<div class="content">
    <div class="grid grid-cols-12 gap-6">
        <div class="col-span-12 2xl:col-span-9">
            <div class="grid grid-cols-12 gap-6">
                <div class="col-span-12 mt-6 -mb-6 intro-y">
                    <div class="alert alert-dismissible show box bg-primary text-white flex items-center mb-6" role="alert">
                        <span>halo, <b><?= $this->session->userdata('nama_user') ?></b> Silahkan kelola dashboard toko online Anda.</span>
                        <button type="button" class="btn-close text-white" data-tw-dismiss="alert" aria-label="Close"> <i data-lucide="x" class="w-4 h-4"></i> </button>
                    </div>
                </div>
                <div class="col-span-12 sm:col-span-6 lg:col-span-4 xl:col-span-4 mt-2 lg:mt-6 xl:mt-2">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Grafik Pesanan
                        </h2>
                        <a href="" class="ml-auto text-primary truncate"></a>
                    </div>
                    <div class="report-box-2 intro-y mt-5">
                        <div class="box p-5">
                            <ul class=" nav nav-pills w-4/5 bg-slate-100 dark:bg-black/20 rounded-md mx-auto " role="tablist">
                                <li id="active-users-tab" class="nav-item flex-1" role="presentation">
                                    <button class="nav-link w-full py-1.5 px-2 active" data-tw-toggle="pill" data-tw-target="#active-users" type="button" role="tab" aria-controls="active-users" aria-selected="true"> Orders Review </button>
                                </li>
                            </ul>
                            <div class="tab-content mt-6">
                                <div class="tab-pane active" id="active-users" role="tabpanel" aria-labelledby="active-users-tab">
                                    <div class="relative">
                                        <div class="h-[208px]">
                                            <div id="chartdiv"></div>
                                        </div>

                                    </div>
                                    <div class="w-52 sm:w-auto mx-auto mt-5">
                                        <div class="flex items-center">
                                            <div class="w-2 h-2 bg-pending rounded-full mr-3"></div>
                                            <span class="truncate">PESANAN BELUM DIBAYAR</span> <span class="font-medium ml-auto"><?= $pending; ?> Orders</span>
                                        </div>
                                        <div class="flex items-center mt-4">
                                            <div class="w-2 h-2 bg-success rounded-full mr-3"></div>
                                            <span class="truncate">PESANAN SUDAH TERBAYAR</span> <span class="font-medium ml-auto"><?= $sukses; ?> Orders</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-span-12 sm:col-span-6 lg:col-span-4 xl:col-span-8 mt-2 lg:mt-6 xl:mt-2">
                    <div class="intro-y flex items-center h-10">
                        <h2 class="text-lg font-medium truncate mr-5">
                            Pesanan Masuk
                        </h2>
                        <a href="" class="ml-auto text-primary truncate"></a>
                    </div>
                    <div class="mt-5">
                        <?php foreach ($bill as $row) : ?>
                            <div class="intro-y">
                                <div class="box px-4 py-4 mb-3 flex items-center zoom-in">
                                    <div class="w-10 h-10 flex-none image-fit rounded-md overflow-hidden">
                                        <img src="<?= base_url('asset') ?>/user.png">
                                    </div>
                                    <div class="ml-4 mr-auto">
                                        <div class="font-medium"><b>#<?= $row->order_id ?></b> | <?= $row->name ?></div>
                                        <div class="text-slate-500 text-xs mt-0.5"><?= date("d F Y H:i:s", strtotime($row->transaction_time)); ?></div>
                                    </div>
                                    <div class="py-1 px-2 rounded-full text-xs bg-danger text-white cursor-pointer font-medium">Menunggu Pembayaran</div>
                                </div>
                            </div>
                        <?php endforeach; ?>
                        <a href="<?= site_url('admin/invoice') ?>" class="intro-y w-full block text-center rounded-md py-4 border border-dotted border-slate-400 dark:border-darkmode-300 text-slate-500">View More</a>
                    </div>
                </div>
                <!-- END: Users By Age -->


            </div>
        </div>
    </div>
</div>

<script src="https://cdn.amcharts.com/lib/5/index.js"></script>
<script src="https://cdn.amcharts.com/lib/5/percent.js"></script>
<script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
<!-- Chart code -->
<script>
    am5.ready(function() {

        // Create root element
        // https://www.amcharts.com/docs/v5/getting-started/#Root_element
        var root = am5.Root.new("chartdiv");

        // Set themes
        // https://www.amcharts.com/docs/v5/concepts/themes/
        root.setThemes([
            am5themes_Animated.new(root)
        ]);

        // Create chart
        // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/
        var chart = root.container.children.push(
            am5percent.PieChart.new(root, {
                startAngle: 160,
                endAngle: 380
            })
        );

        // Create series
        // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Series

        var series0 = chart.series.push(
            am5percent.PieSeries.new(root, {
                valueField: "litres",
                categoryField: "country",
                startAngle: 160,
                endAngle: 380,
                radius: am5.percent(70),
                innerRadius: am5.percent(65)
            })
        );

        var colorSet = am5.ColorSet.new(root, {
            colors: [series0.get("colors").getIndex(0)],
            passOptions: {
                lightness: -0.05,
                hue: 0
            }
        });

        series0.set("colors", colorSet);

        series0.ticks.template.set("forceHidden", true);
        series0.labels.template.set("forceHidden", true);

        var series1 = chart.series.push(
            am5percent.PieSeries.new(root, {
                startAngle: 160,
                endAngle: 380,
                valueField: "bottles",
                innerRadius: am5.percent(80),
                categoryField: "country"
            })
        );

        series1.ticks.template.set("forceHidden", true);
        series1.labels.template.set("forceHidden", true);

        var label = chart.seriesContainer.children.push(
            am5.Label.new(root, {
                textAlign: "center",
                centerY: am5.p100,
                centerX: am5.p50,
                text: "[fontSize:16px]Pesanan [/]:\n[bold fontSize:20px]<?= $count; ?> Order[/]"
            })
        );

        var data = [{
                country: "Lithuania",
                litres: 501.9,
                bottles: 1500
            },
            {
                country: "Czech Republic",
                litres: 301.9,
                bottles: 990
            },
            {
                country: "Ireland",
                litres: 201.1,
                bottles: 785
            },
            {
                country: "Germany",
                litres: 165.8,
                bottles: 255
            },
            {
                country: "Australia",
                litres: 139.9,
                bottles: 452
            },
            {
                country: "Austria",
                litres: 128.3,
                bottles: 332
            },
            {
                country: "UK",
                litres: 99,
                bottles: 150
            },
            {
                country: "Belgium",
                litres: 60,
                bottles: 178
            },
            {
                country: "The Netherlands",
                litres: 50,
                bottles: 50
            }
        ];

        // Set data
        // https://www.amcharts.com/docs/v5/charts/percent-charts/pie-chart/#Setting_data
        series0.data.setAll(data);
        series1.data.setAll(data);

    }); // end am5.ready()
</script>