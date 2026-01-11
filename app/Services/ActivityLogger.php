<?php

namespace App\Services;

use App\Models\ActivityLog;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class ActivityLogger
{
    /**
     * Log an activity.
     *
     * @param string $action The action performed (created, updated, deleted, voted, etc.)
     * @param Model $model The model being acted upon
     * @param array|null $oldValues Previous values (for updates)
     * @param array|null $newValues New values (for creates/updates)
     * @return ActivityLog
     */
    public static function log(
        string $action,
        Model $model,
        ?array $oldValues = null,
        ?array $newValues = null
    ): ActivityLog {
        return ActivityLog::create([
            'user_id' => Auth::id(),
            'action' => $action,
            'model_type' => get_class($model),
            'model_id' => $model->getKey(),
            'old_values' => $oldValues,
            'new_values' => $newValues,
            'ip_address' => request()->ip() ?? '0.0.0.0',
            'user_agent' => request()->userAgent(),
        ]);
    }

    /**
     * Log a model creation.
     */
    public static function logCreated(Model $model): ActivityLog
    {
        return static::log('created', $model, null, $model->toArray());
    }

    /**
     * Log a model update.
     */
    public static function logUpdated(Model $model, array $oldValues): ActivityLog
    {
        return static::log('updated', $model, $oldValues, $model->toArray());
    }

    /**
     * Log a model deletion.
     */
    public static function logDeleted(Model $model): ActivityLog
    {
        return static::log('deleted', $model, $model->toArray(), null);
    }

    /**
     * Log a vote action.
     */
    public static function logVoted(Model $model, string $voteType): ActivityLog
    {
        return static::log('voted', $model, null, ['vote_type' => $voteType]);
    }

    /**
     * Log a custom action.
     */
    public static function logCustom(string $action, Model $model, ?array $data = null): ActivityLog
    {
        return static::log($action, $model, null, $data);
    }
}
