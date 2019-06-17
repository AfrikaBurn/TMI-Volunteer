<?php

namespace Tests\Unit;

use App\Models\Department;
use App\Models\Event;
use App\Models\EventRole;
use App\Models\Role;
use App\Models\Schedule;
use App\Models\Shift;
use App\Models\Slot;
use App\Models\User;
use App\Models\UserData;
use App\Models\UserRole;
use App\Models\UserUpload;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class FactoryTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @test
     *
     * @return void
     */
    public function department_factory_is_working()
    {
        factory(Department::class)->states('with-setup')->create();
        $this->assertTrue(true); //tests no exception thrown
    }

    /**
     * @test
     *
     * @return void
     */
    public function event_factory_is_working()
    {
        factory(Event::class)->states('with-setup')->create();
        $this->assertTrue(true); //tests no exception thrown
    }

    /**
     * @test
     *
     * @return void
     */
    public function event_role_factory_is_working()
    {
        //WIP
        //factory(EventRole::class)->states('with-setup')->create();
        $this->assertTrue(true); //tests no exception thrown
    }

    /**
     * @test
     *
     * @return void
     */
    public function role_factory_is_working()
    {
        factory(Role::class)->states('with-setup')->create();
        $this->assertTrue(true); //tests no exception thrown
    }

    /**
     * @test
     *
     * @return void
     */
    public function schedule_factory_is_working()
    {
        factory(Schedule::class)->states('with-setup')->create();
        $this->assertTrue(true); //tests no exception thrown
    }

    /**
     * @test
     *
     * @return void
     */
    public function shift_factory_is_working()
    {
        factory(Shift::class)->states('with-setup')->create();
        $this->assertTrue(true); //tests no exception thrown
    }

    /**
     * @test
     *
     * @return void
     */
    public function slot_factory_is_working()
    {
        factory(Slot::class)->states('with-setup')->create();
        $this->assertTrue(true); //tests no exception thrown
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_factory_is_working()
    {
        factory(User::class)->states('with-setup')->create();
        $this->assertTrue(true); //tests no exception thrown
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_data_factory_is_working()
    {
        factory(UserData::class)->states('with-setup')->create();
        $this->assertTrue(true); //tests no exception thrown
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_role_factory_is_working()
    {
        factory(UserRole::class)->states('with-setup')->create();
        $this->assertTrue(true); //tests no exception thrown
    }

    /**
     * @test
     *
     * @return void
     */
    public function user_upload_factory_is_working()
    {
        factory(UserUpload::class)->states('with-setup')->create();
        $this->assertTrue(true); //tests no exception thrown
    }

}
