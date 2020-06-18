using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public static class IncreaseExperience 
{

    private static int xpToGive;
    private static LevelUp levelUpScript = new LevelUp();

    public static void AddExperience()
    {
        xpToGive = GameInformation.PlayerLevel * 100;
        GameInformation.CurrentXP += xpToGive;
        CheckToSeeIfPlayerLeveled();
        Debug.Log(xpToGive);
    }

    public static void AddExperienceFromBattleLoss()
    {
        xpToGive = GameInformation.PlayerLevel * 10;
        GameInformation.CurrentXP += xpToGive;
    }

    private static void CheckToSeeIfPlayerLeveled()
    {
        if (GameInformation.CurrentXP >= GameInformation.RequiredXP)
        {
            //then the player levels up
            levelUpScript.LevelUpCharacter();
            //CREATE LEVEL UP SCRIPT
        }
    }

   
}
