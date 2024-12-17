<?php

namespace App\Exports;

use App\Models\Payments;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use Illuminate\Support\Facades\DB;

class PaymentExport implements FromCollection, WithHeadings, WithStyles
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
        return DB::table('payments')
            -> join('users', 'payments.users_id', '=', 'users.id')
            -> select('pay_id', 'description', 'payment_date', 'payment_method', 'amount', 'users.name as name')
            ->whereBetween('payment_date', [$this->startDate, $this->endDate])
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
            'Mã thanh toán',
            'Mô tả',
            'Ngày thanh toán',
            'Phương thức thanh toán',
            'Số tiền',
            'Tài khoản thanh toán',
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
