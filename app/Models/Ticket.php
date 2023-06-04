<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasEvents;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory, HasEvents;
    protected $fillable = [
        'ticket_user_id',
        'ticket_status_id',
        'ticket_category_id',
        'ticket_department_id',
        'title',
        'message',
        'priority'
    ];

    /**
     * Get the owner that owns the Ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'ticket_user_id', 'id');
    }

    /**
     * Get the status associated with the Ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function status()
    {
        return $this->hasOne(TicketStatus::class, 'id', 'ticket_status_id');
    }

    /**
     * Get the category associated with the Ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function category()
    {
        return $this->hasOne(TicketCategory::class, 'id', 'ticket_category_id');
    }

    /**
     * Get all of the comments for the Ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function comments()
    {
        return $this->hasMany(Comment::class, 'ticket_id', 'id');
    }

    /**
     * Get all of the logs for the Ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function logs()
    {
        return $this->hasMany(TicketLog::class, 'ticket_id', 'id');
    }

    /**
     * Get the department associated with the Ticket
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function department()
    {
        return $this->hasOne(Role::class, 'id', 'ticket_department_id');
    }
}
