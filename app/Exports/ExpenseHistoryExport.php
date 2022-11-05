<?php

namespace App\Exports;

use App\Expense;
use Illuminate\Contracts\Support\Responsable;
use Illuminate\Database\Eloquent\Collection;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromArray;
use Maatwebsite\Excel\Concerns\FromQuery;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use Maatwebsite\Excel\Concerns\WithMapping;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;

class ExpenseHistoryExport implements FromArray,ShouldAutoSize,WithHeadings
{
    use Exportable;
    
    protected $from_date;
    protected $to_date;
    
    
    public function __construct($from,$to){
        $this->from_date = $from;
        $this->to_date = $to;
        
    }
    
   
    public function array() :array
    {
         $expenses = Expense::whereBetween('date',[$this->from_date, $this->to_date])->get();
            $expense_lists = array();
            foreach($expenses as $expense){
                   
                    if($expense->type = 1){
                        $type = 'Fixed';
                    }else{
                        $type = 'Variable';
                    }
                    
                    if($expense->period = 1){
                        $period = 'Daily';
                    }else if($expense->period = 2){
                        $period = 'Weekly';
                    }else{
                        $period = 'Monthly';
                    }
                    
                    $date = $expense->date;
                    $title = $expense->title;
                    $description = $expense->description;
                    $amount = $expense->amount;
                    
                    $combined = array('type' => $type, 'period' => $period, 'date' => $date, 'title' => $title, 'description' => $description, 'amount' => $amount);

                    array_push($expense_lists, $combined);
                
            }
            return $expense_lists;
       
    }
    
    
    public function headings():array{
       
            return [
            'Type',
            'Period',
            'Date',
            'Title',
            'Description',
            'Amount',
        ];
        
    }
    
    
}