<?php

namespace RemoteControl;

use Carbon\Carbon;
use Illuminate\Contracts\Auth\Authenticatable;
use Illuminate\Contracts\Hashing\Hasher as HasherContract;
use Illuminate\Database\ConnectionInterface;
use Illuminate\Database\Query\Builder as QueryBuilder;

class DatabaseTokenRepository implements Contracts\TokenRepository
{
    use Concerns\GeneratesAccessTokens;

    /**
     * The database connection instance.
     *
     * @var \Illuminate\Database\ConnectionInterface
     */
    protected $connection;

    /**
     * The Hasher implementation.
     *
     * @var \Illuminate\Contracts\Hashing\Hasher
     */
    protected $hasher;

    /**
     * The token database table.
     *
     * @var string
     */
    protected $table;

    /**
     * The number of seconds a token should last.
     *
     * @var int
     */
    protected $expires;

    /**
     * Create a new token repository instance.
     *
     * @return void
     */
    public function __construct(
        ConnectionInterface $connection,
        HasherContract $hasher,
        string $table,
        string $hashKey
    ) {
        $this->table = $table;
        $this->hasher = $hasher;
        $this->hashKey = $hashKey;
        $this->connection = $connection;
    }

    /**
     * Create a new token.
     *
     * @return \RemoteControl\Contracts\AccessToken
     */
    public function create(Authenticatable $user, string $email): Contracts\AccessToken
    {
        // We will create a new, random token for the user so that we can e-mail them
        // a safe link to the password reset form. Then we will insert a record in
        // the database so that we can verify the token within the actual reset.
        $secret = $this->generateSecret();
        $verificationCode = $this->generateVerificationCode();

        $recordId = $this->getTable()->insertGetId($this->getPayload($user, $email, $secret, $verificationCode));

        return new AccessToken($secret, $verificationCode, [
            'id' => $recordId,
            'user_id' => $user->getKey(),
            'email' => $email,
        ]);
    }

    /**
     * Mark token as used.
     *
     * @param int $recordId
     */
    public function markAsUsed($recordId): void
    {
        $this->getTable()
                ->where('id', $recordId)
                ->update([
                    'used_at' => new Carbon(),
                ]);
    }

    /**
     * Query existing record exists and yet to expired.
     *
     * @return \RemoteControl\Contracts\AccessToken|null
     */
    public function query(string $email, string $secret, string $verificationCode): ?Contracts\AccessToken
    {
        $record = $this->getTable()
                        ->where('email', $email)
                        ->where('verification_code', $verificationCode)
                        ->whereNull('used_at')
                        ->first();

        if (! \is_null($record) && $this->hasher->check($secret, $record->secret)) {
            return new AccessToken($secret, $verificationCode, [
                'id' => $record->id,
                'user_id' => $record->user_id,
                'email' => $email,
            ]);
        }

        return null;
    }

    /**
     * Build the record payload for the table.
     */
    protected function getPayload(Authenticatable $user, string $email, string $secret, string $verificationCode): array
    {
        return [
            'user_id' => $user->getKey(),
            'email' => $email,
            'secret' => $this->hasher->make($secret),
            'verification_code' => $verificationCode,
            'created_at' => new Carbon(),
            'used_at' => null,
        ];
    }

    /**
     * Begin a new database query against the table.
     */
    protected function getTable(): QueryBuilder
    {
        return $this->connection->table($this->table);
    }
}
