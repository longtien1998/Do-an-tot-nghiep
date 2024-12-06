<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class MusicExport implements FromCollection, WithHeadings, WithStyles
{
    protected $startDate;
    protected $endDate;

    public function __construct($startDate, $endDate)
    {
        $this->startDate = $startDate;
        $this->endDate = $endDate;
    }

    /**
     * Lấy dữ liệu xuất file Excel.
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        return  DB::table('ranking_logs')
        ->join('songs', 'ranking_logs.song_id', '=', 'songs.id')
        ->select('songs.song_name as song_name', 'ranking_logs.listen_count', 'ranking_logs.download_count', 'ranking_logs.like_count', 'ranking_logs.date')
        ->whereBetween('ranking_logs.date', [$this->startDate, $this->endDate])
        ->get();
    }

    /**
     * Tiêu đề của file Excel.
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'Tên bài hát',
            'Lượt nghe',
            'Lượt tải',
            'Lượt thích',
            'Ngày',
        ];
    }

    /**
     * Tùy chỉnh style cho sheet.
     *
     * @param Worksheet $sheet
     * @return array
     */
    public function styles(Worksheet $sheet)
    {
        return [
            1 => ['font' => ['bold' => true]], // In đậm dòng tiêu đề
        ];
    }
}
