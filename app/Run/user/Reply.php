<?php

namespace App\Run\user;

use App\Classes\Base as BaseClass;
use App\Classes\enum\constant;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use App\Models\Ticket;
use App\Models\TicketFiles;
use App\Models\TicketItems;

class Reply extends BaseClass\Model
{
    public $user;
    public $ticket;

    public $ticketId;
    public $description;
    public $attachment;

    public function AttributesLabel()
    {
        return 
        [
            'ticketId' => textLabel(68,'attributes'),
            'description' => textLabel(10,'attributes'),
            'attachment' => textLabel(69,'attributes'),
        ];
    }

    public function Rules()
    {
        return 
        [
            'ticketId' => ['required','integer','min:1'],
            'description' => ['required','string'],
            'attachment' => ['nullable','array'],
            'attachment.*' => ['nullable','file','max:2048'],
        ];
    }

    public function Verify()
    {
        try
        {
            $this->ticket = Ticket::where('id',$this->ticketId)
            ->where('userId',$this->user->id)
            ->where('status', '!=', constant::TICKET_CLOSED->value)
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
            DB::beginTransaction();
            $time = time();
            $ticketItem = new TicketItems();
            $ticketItem->ticketId = $this->ticketId;
            $ticketItem->description = $this->description;
            $ticketItem->time = $time;
            $ticketItem->save();

            if(!empty($this->attachment))
            {
                foreach($this->attachment as $item)
                {
                    $k = 0;
                    while($k == 0)
                    {
                        $fileCode = rand(10000000,99999999);
                        if(TicketFiles::where('name', $fileCode)->first())
                            continue;

                        $k = 1;
                    }

                    $originalPath = $item;
                    $extension = $item->getClientOriginalExtension();

                    $ftpPath = constant::LINK_TICKET->value . $fileCode . '.' . $extension;
                    $uploadSuccess = Storage::disk('ftp')->put($ftpPath, file_get_contents($originalPath));
                    
                    $files[] =
                    [
                        'ticketItemId' => $ticketItem->id,
                        'name' => $fileCode,
                        'type' => $extension
                    ];
                }

                TicketFiles::insert($files);
            }

            $this->ticket->lastUpdate = $time;
            $this->ticket->status = constant::TICKET_OPENED->value;
            $this->ticket->update();
            DB::commit();
       } catch (\Exception $e) 
       {
            DB::rollBack();

            return $this->AddRuntimeError('serverNotConnected',textLabel(2,'errors'));
       }

       return true;
    }
}
