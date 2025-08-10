<?php

namespace App\Run\user;

use App\Classes\Base as BaseClass;
use App\Classes\enum\constant;
use App\Models\Manager;
use App\Models\Ticket;
use App\Models\TicketFiles;
use App\Models\TicketItems;

class Show extends BaseClass\Model
{
    public $user;
    public $output;

    public $ticketId;

    public function AttributesLabel()
    {
        return
        [
            'ticketId' => textLabel(68,'attributes')
        ];
    }

    public function Rules()
    {
        return
        [
            'ticketId' => ['required','integer','min:1'],
        ];
    }

    public function Verify()
    {
        $ticket = Ticket::where('id',$this->ticketId)
        ->where('userId',$this->user->id)
        ->first();

        if(empty($ticket))
            return $this->AddRuntimeError('notExistTicket',textLabel(40,'errors'));

        $items = TicketItems::where('ticketId',$this->ticketId)
        ->orderBy('time','DESC')
        ->get()
        ->toArray();

        $files = TicketFiles::where('ticketItemId',array_column($items,'id'))
        ->get();

        $managers = Manager::whereIn('id',array_column($items,'managerId'))
        ->get()
        ->keyBy('id');

        $ticketItem = [];
        $ticketFile = [];

        if(count($ticketFile) != 0)
        {
            foreach($files as $item)
            {
                $ticketFile[$item['ticketItemId']][] = constant::MEDIA->value.constant::LINK_TICKET->value.$item['name'].'.'.$item['type'];
            }
        }

        foreach($items as $item)
        {
            $ticketItem[] =
            [
                'manager' => empty($item['managerId']) ? '' : $managers[$item['managerId']]['fullName'],
                'description' => $item['description'],
                'time' => convertToPersianDate($item['time']),
                'attachment' => empty($ticketFile[$item['id']]) ? '' : $ticketFile[$item['id']]
            ];
        }

        $this->output['title'] = $ticket->title;
        $this->output['time'] = convertToPersianDate($ticket->time);
        $this->output['lastUpdate'] = convertToPersianDate($ticket->lastUpdate);
        $this->output['status'] = $ticket->status;
        $this->output['items'] = $ticketItem;

        return true;
    }

    public function Run()
    {
        return $this->output;
    }
}
