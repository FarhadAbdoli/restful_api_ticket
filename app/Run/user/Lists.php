<?php

namespace App\Run\user;

use App\Classes\Base as BaseClass;
use App\Classes\enum\constant;
use App\Models\Ticket;
use Illuminate\Validation\Rule;

class Lists extends BaseClass\Model
{
    public $user;
    public $output;

    public $page;
    public $status;
    public $code;

    public function AttributesLabel()
    {
        return
        [
            'page' => textLabel(34,'attributes'),
            'status' => textLabel(8,'attributes'),
            'code' => textLabel(57,'attributes')
        ];
    }

    public function Rules()
    {
        return
        [
            'page' => ['required','integer','min:1','max:1000'],
            'status' => ['nullable', Rule::in(
                [
                    constant::TICKET_OPENED->value,
                    constant::TICKET_PROGRESS->value,
                    constant::TICKET_ANSWERED->value,
                    constant::TICKET_CLOSED->value
                ]
            )],
            'code' => ['nullable','integer','min:1'],
        ];
    }

    public function Verify()
    {

        $query = Ticket::query();
        $query->where('userId', $this->user->id);

        if(!empty($this->status))
            $query->where('status', $this->status);

        if(!empty($this->code))
            $query->where('id', $this->code);

        $ticket = $query->orderBy('lastUpdate','DESC')->paginate(10);
        $this->output['current_page'] = $ticket->currentPage();
        $this->output['last_page'] = $ticket->lastPage();
        $this->output['per_page'] = $ticket->perPage();
        $this->output['data'] = [];

        if(count($ticket) != 0)
        {
            foreach($ticket as $item)
            {
                $this->output['data'][] =
                [
                    'id' => $item->id,
                    'title' => $item->title,
                    'time' => convertToPersianDate($item->time),
                    'lastUpdate' => convertToPersianDate($item->lastUpdate),
                    'status' => $item->status,
                ];
            }
        }

        return true;
    }

    public function Run()
    {
        return $this->output;
    }
}
