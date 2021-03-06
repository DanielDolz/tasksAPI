<?php

/**
 * Created by PhpStorm.
 * User: adam
 * Date: 26/02/16
 * Time: 15:43
 */
use Illuminate\Foundation\Testing\DatabaseMigrations;

class TagsAPITest extends TestCase
{

    use DatabaseMigrations;

    /**
     * A basic functional test example.
     *
     * @return void
     */
    public function testTagsUseJson()
    {
        $this->get('/tag')->seeJson()->seeStatusCode(200);
    }

    /**
     * Test tags in database are listed by API
     *
     * @return void
     */
    public function testTagsInDatabaseAreListedByAPI()
    {
        $this->createFakeTags();
        $this->get('/tag')
            ->seeJsonStructure([
                '*' => [
                    'title'
                ]
            ])->seeStatusCode(200);
    }

    /**
     * Test tag Return 404 on tag not exsists
     *
     * @return void
     */
    public function testTagsReturn404OnTaskNotExsists()
    {
        $this->get('/tag/500')->seeJson()->seeStatusCode(404);
    }

    /**
     * Test tags in database is shown by API
     *
     * @return void
     */
    public function testTagsInDatabaseAreShownByAPI()
    {
        $tag = $this->createFakeTag();
        $this->get('/tag/' . $tag->id)
            ->seeJsonContains(['title' => $tag->title])
            ->seeStatusCode(200);
    }

    /**
     * Create fake tag
     *
     * @return \App\Tag
     */
    private function createFakeTag() {
        $faker = Faker\Factory::create();
        $tag = new \App\Tag();

        $tag->title = $faker->word;
        $tag->save();

        return $tag;
    }

    /**
     * Create fake tags
     *
     * @param int $count
     * @return \App\Tag
     */
    private function createFakeTags($count = 10) {
        foreach (range(0,$count) as $number) {
            $this->createFakeTag();
        }
    }

    /**
     * Test tags can be posted and saved to database
     *
     * @return void
     */
    public function testTagsCanBePostedAndSavedIntoDatabase()
    {
        $data = ['title' => 'Foobar'];
        $this->post('/tag',$data)->seeInDatabase('tags',$data);
        $this->get('/tag')->seeJsonContains($data)->seeStatusCode(200);
    }

    /**
     * Test tags can be update and see changes on database
     *
     * @return void
     */
    public function testTagsCanBeUpdatedAndSeeChangesInDatabase()
    {
        $tag = $this->createFakeTag();
        $data = [ 'title' => 'Learn Laravel'];
        $this->put('/tag/' . $tag->id, $data)->seeInDatabase('tags',$data);
        $this->get('/tag')->seeJsonContains($data)->seeStatusCode(200);
    }

    /**
     * Test tagss can be deleted and not see on database
     *
     * @return void
     */
    public function testTagsCanBeDeletedAndNotSeenOnDatabase()
    {
        $tag = $this->createFakeTag();
        $data = [ 'title' => $tag->title];
        $this->delete('/tag/' . $tag->id)->notSeeInDatabase('tags',$data);
        $this->get('/tag')->dontSeeJson($data)->seeStatusCode(200);
    }
}