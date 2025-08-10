<?php

namespace App\Run\user;

use App\Classes\Base as BaseClass;
use App\Classes\enum\constant;
use App\Models\Ticket;
class ChangeStatus extends BaseClass\Model
{
    public $user;
    public $ticket;

    public $ticketId;

    public function AttributesLabel()
    {
        return 
        [
            'ticketId' => textLabel(68,'attributes'),
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
            $this->ticket->status = constant::TICKET_CLOSED->value;
            $this->ticket->update();

       } catch (\Exception $e) 
       {
            return $this->AddRuntimeError('serverNotConnected',textLabel(2,'errors'));
       }

       return true;
    }
}
