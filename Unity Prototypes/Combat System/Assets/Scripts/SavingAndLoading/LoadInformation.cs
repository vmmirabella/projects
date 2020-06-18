﻿using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class LoadInformation 
{
    public static void LoadAllInformation()
    {
        GameInformation.PlayerName = PlayerPrefs.GetString("PLAYERNAME");
        GameInformation.PlayerLevel = PlayerPrefs.GetInt("PLAYERLEVEL");
        GameInformation.Stamina = PlayerPrefs.GetInt("STAMINA"); 
        GameInformation.Endurance = PlayerPrefs.GetInt("ENDURANCE"); 
        GameInformation.Strength = PlayerPrefs.GetInt("STRENGTH"); 
        GameInformation.Intellect = PlayerPrefs.GetInt("INTELLECT"); 
        GameInformation.Overpower = PlayerPrefs.GetInt("OVERPOWER"); 
        GameInformation.Luck = PlayerPrefs.GetInt("LUCK");
        GameInformation.Mastery = PlayerPrefs.GetInt("MASTERY");
        GameInformation.Charisma = PlayerPrefs.GetInt("CHARISMA");
        GameInformation.Gold = PlayerPrefs.GetInt("GOLD"); 

        if (PlayerPrefs.GetString("EQUIPMENTITEM1") != null)
        {
            GameInformation.EquipmentOne = (BaseEquipment) PPSerialization.Load("EQUIPMENTITEM1");
        }

    }
}
