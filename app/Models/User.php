<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'username',
        'email',
        'password',
        'is_admin',
        'role',       // New
        'banned_at',  // New
        'ban_reason'  // New
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the words submitted by this user
     */
    public function words()
    {
        return $this->hasMany(Word::class); // Warning: Word table might not have user_id if we didn't add it yet? 
        // Checking schema... Word has no user_id in migration? 
        // Let's check Word migration.
    }
    
    // Actually, I should check if words table has user_id. 
    // If not, I can't do this relationship yet.
    // Based on '2026_01_10_000001_create_words_table.php':
    // $table->foreignId('user_id')->nullable()->constrained()->nullOnDelete(); 
    // Yes, it has user_id.
    
    public function definitions()
    {
        return $this->hasMany(Definition::class);
    }
}
