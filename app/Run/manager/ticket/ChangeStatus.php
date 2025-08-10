<?php

namespace App\Run\manager\ticket;

use App\Classes\Base as BaseClass;
use App\Classes\enum\constant;
use App\Models\Ticket;
use Illuminate\Validation\Rule;

class ChangeStatus extends BaseClass\Model
{
    public $manager;
    public $ticket;

    public $ticketId;
    public $action;

    public function AttributesLabel()
    {
        return 
        [
            'ticketId' => textLabel(68,'attributes'),
            'action' => textLabel(70,'attributes'),
        ];
    }

    public function Rules()
    {
        return 
        [
            'ticketId' => ['required','integer','min:1'],
            'action' => ['required', Rule::in(
                [
                    constant::TICKET_CLOSED->value,
                    constant::TICKET_PROGRESS->value,
                ]
            )],
        ];
    }

    public function Verify()
    {
        try
        {
            $this->ticket = Ticket::where('id',$this->ticketId)
            ->first();

            if(empty($this->ticket))
                return $this->AddRuntimeError('notExistTicket',textLabel(40,'errors'));


        } catch (\Exception $e)
        {
            return $this->AddRuntimeError('serverNotConnected',textLabel(2,'errors'));
        }
        
        return true;
    }

    public function Run()
    {
       try 
       {
            $this->ticket->status = $this->action;
            $this->ticket->update();

       } catch (\Exception $e) 
       {
            return $this->AddRuntimeError('serverNotConnected',textLabel(2,'errors'));
       }

       return true;
    }
}
