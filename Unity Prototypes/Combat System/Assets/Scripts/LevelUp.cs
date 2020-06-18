using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class LevelUp
{
    public int maxPlayerLevel =50;

    public void LevelUpCharacter()
    {
        //check to see if current xp > required xp
        if(GameInformation.CurrentXP > GameInformation.RequiredXP)
        {
            GameInformation.CurrentXP -= GameInformation.RequiredXP;
        }else
        {
            GameInformation.CurrentXP = 0;
        }
        //increase playerlevel
        if(GameInformation.PlayerLevel < maxPlayerLevel)
        {
            GameInformation.PlayerLevel+=1;
        } else //else make sure the player doesn't go above the max level stated
        {
            GameInformation.PlayerLevel = maxPlayerLevel;
        }

        //give player stat points
        //randomly give items
        //give them a move/abilities
        //give money
        //determine the next amount of required xp
        DetermineRequiredXP();


    }

    private void DetermineRequiredXP()
    {
        int temp = GameInformation.PlayerLevel * 1000 + 250;
        GameInformation.RequiredXP = temp;
    }

    private void DetermineMoneyToGive()
    {
        if(GameInformation.PlayerLevel <= 10)
        {
            //give a certain amount of money
        }
    }

    
     private int DetermineXPForNextLevel (int playerLevel){
        playerLevel += 1;
        int levels = 50;
        float xpLevel1 = 500.0f;
        float xpLevel50 = 400000.0f;
        float temp1 = Mathf.Log(xpLevel50 / xpLevel1);
        float b = temp1 / (levels - 1);
        float temp2 = (Mathf.Exp(b) - 1);
        float a = (xpLevel1) / temp2;
        int oldxp = (int)(a * Mathf.Exp((float)b * (playerLevel - 1)));
        int newxp = (int)(a * Mathf.Exp((float)b * playerLevel));
        int temp = newxp - oldxp;
        temp= (int) Mathf.Round((float)temp / 10.0f * 10);
        return temp;


    }
     
     
     
     
     
     
     
     
}
