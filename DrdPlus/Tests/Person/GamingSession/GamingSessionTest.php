<?php
namespace DrdPlus\Tests\Person\GamingSession;

use DrdPlus\Person\GamingSession\Adventure;
use DrdPlus\Person\GamingSession\GamingSession;
use DrdPlus\Person\GamingSession\GamingSessionCategoryExperiences;
use DrdPlus\Tables\Measurements\Experiences\Experiences;
use DrdPlus\Tables\Tables;
use Granam\Tests\Tools\TestWithMockery;

class GamingSessionTest extends TestWithMockery
{
    /**
     * @test
     */
    public function I_can_use_it()
    {
        $gamingSession = new GamingSession(
            $adventure = $this->createAdventure(),
            $rolePLayingExperiences = $this->createGamingSessionCategoryExperiences(1),
            $difficultiesSolvingExperiences = $this->createGamingSessionCategoryExperiences(2),
            $abilityUsageExperiences = $this->createGamingSessionCategoryExperiences(3),
            $companionsHelpingExperiences = $this->createGamingSessionCategoryExperiences(0),
            $gameContributingExperiences = $this->createGamingSessionCategoryExperiences(1),
            $sessionName = 'foo'
        );
        self::assertNull($gamingSession->getId());
        self::assertSame($adventure, $gamingSession->getAdventure());
        self::assertSame($rolePLayingExperiences, $gamingSession->getRolePlayingExperiences());
        self::assertSame($difficultiesSolvingExperiences, $gamingSession->getDifficultiesSolvingExperiences());
        self::assertSame($abilityUsageExperiences, $gamingSession->getAbilityUsageExperiences());
        self::assertSame($companionsHelpingExperiences, $gamingSession->getCompanionsHelpingExperiences());
        self::assertSame($gameContributingExperiences, $gamingSession->getGameContributingExperiences());
        self::assertSame($sessionName, $gamingSession->getSessionName());

        $experiences = $gamingSession->getExperiences((new Tables())->getExperiencesTable());
        self::assertInstanceOf(Experiences::class, $experiences);
        $sameExperiencesNewInstance = $gamingSession->getExperiences((new Tables())->getExperiencesTable());
        self::assertEquals($experiences, $sameExperiencesNewInstance);
        self::assertNotSame($experiences, $sameExperiencesNewInstance);

        self::assertSame($rolePLayingExperiences->getValue() + $difficultiesSolvingExperiences->getValue()
            + $abilityUsageExperiences->getValue() + $companionsHelpingExperiences->getValue()
            + $gameContributingExperiences->getValue(),
            $experiences->getValue()
        );
    }

    /**
     * @return \Mockery\MockInterface|Adventure
     */
    private function createAdventure()
    {
        return $this->mockery(Adventure::class);
    }

    /**
     * @param $value
     * @return \Mockery\MockInterface|GamingSessionCategoryExperiences
     */
    private function createGamingSessionCategoryExperiences($value)
    {
        $experiences = $this->mockery(GamingSessionCategoryExperiences::class);
        $experiences->shouldReceive('getValue')
            ->andReturn($value);

        return $experiences;
    }
}
