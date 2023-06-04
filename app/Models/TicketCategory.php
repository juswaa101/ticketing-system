<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketCategory extends Model
{
    use HasFactory;
    protected $fillable = ['category_name'];

    /**
     * Get the ticket that owns the TicketCategory
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function ticket()
    {
        return $this->hasMany(Ticket::class, 'ticket_category_id', 'id');
    }
}
