<?php
if (!function_exists('format_periode')) {
    /**
     * Format Periode Tanggal
     *
     * @param string $start_date Format: Y-m-d
     * @param string $end_date Format: Y-m-d
     * @return string
     */
    function format_periode($start_date, $end_date)
    {
        // Pastikan format tanggal valid
        if (!strtotime($start_date) || !strtotime($end_date)) {
            return 'Invalid date format';
        }

        // Ubah tanggal menjadi objek DateTime
        $start = new DateTime($start_date);
        $end = new DateTime($end_date);

        // Format tanggal menjadi string
        $start_day = $start->format('d');
        $start_month = $start->format('F'); // Full month name
        $end_day = $end->format('d');
        $end_month = $end->format('F'); // Full month name
        $year = $start->format('Y');

        // Konversi nama bulan ke Bahasa Indonesia
        $months = [
            'January' => 'Januari',
            'February' => 'Februari',
            'March' => 'Maret',
            'April' => 'April',
            'May' => 'Mei',
            'June' => 'Juni',
            'July' => 'Juli',
            'August' => 'Agustus',
            'September' => 'September',
            'October' => 'Oktober',
            'November' => 'November',
            'December' => 'Desember',
        ];

        $start_month = $months[$start_month] ?? $start_month;
        $end_month = $months[$end_month] ?? $end_month;

        // Jika beda bulan
        if ($start_month !== $end_month) {
            return "$start_day $start_month - $end_day $end_month $year";
        }

        // Jika bulan sama
        return "$start_day-$end_day $start_month $year";
    }
}
