<?php

namespace App\DataTables;

use App\Enums\UsersType;
use App\Models\Receiver;
use App\Services\ReceiverService;
use Illuminate\Database\Eloquent\Builder as QueryBuilder;
use Yajra\DataTables\EloquentDataTable;
use Yajra\DataTables\Html\Builder as HtmlBuilder;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Services\DataTable;

class ReceiversDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param QueryBuilder $query Results from query() method.
     * @return \Yajra\DataTables\EloquentDataTable
     */
    public function dataTable(QueryBuilder $query): EloquentDataTable
    {
        return (new EloquentDataTable($query))
            ->setRowId('id')
            ->addColumn('company_id', function (Receiver $receiver) {
                return $receiver->branch->company->name;
            })
            ->editColumn('branch_id', function (Receiver $receiver) {
                return $receiver->branch->name;
            })->addColumn('action', function (Receiver $receiver) {
                return view(
                    'layouts.dashboard.receivers.components._actions',
                    ['model' => $receiver,'url'=>route('receivers.destroy',$receiver->id)]
                );
            });
    }

    /**
     * @param ReceiverService $model
     * @return QueryBuilder
     */
    public function query(ReceiverService $receiverService): QueryBuilder
    {
        return $receiverService->datatable(filters: $this->filters , withRelations: $this->withRelations);
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html(): HtmlBuilder
    {
        return $this->builder()
                    ->setTableId('receivers-table')
                    ->columns($this->getColumns())
                    ->minifiedAjax()
                    //->dom('Bfrtip')
                    ->orderBy(1)
                    ->selectStyleSingle()
                    ->buttons([
                        Button::make('reload')
                    ]);
    }

    /**
     * Get the dataTable columns definition.
     *
     * @return array
     */
    public function getColumns(): array
    {
        return [
            Column::make('id')->title("#"),
            Column::make('name')->title(trans('app.receiver_name'))->orderable(false),
            Column::make('receiving_company')->title(trans('app.receiving_company'))->orderable(false),
            Column::make('reference')->title(trans('app.reference'))->orderable(false),
            Column::make('company_id')->title(trans('app.company'))->searchable(false)->orderable(false),
            Column::make('branch_id')->title(trans('app.branch'))->searchable(false)->orderable(false),
            Column::computed('action')
                ->exportable(false)
                ->printable(false)
                ->addClass('text-center'),
        ];

    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename(): string
    {
        return 'Reveivers_' . date('YmdHis');
    }
}
