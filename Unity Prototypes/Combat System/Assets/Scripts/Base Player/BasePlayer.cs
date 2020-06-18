using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BasePlayer
{
    private string playerName;
    private int playerLevel;
    private BaseCharacterClass playerClass;

    private int stamina;        //health modifier
    private int endurance;      //energy modifier
    private int intellect;      //magical damage modifier
    private int strength;       //physical damage modifier
    private int overpower;        //haste and crit modifier  
    private int luck;
    private int mastery;
    private int charisma;
    private int gold;           //in-game currency

    private int currentXP;
    private int requiredXP;

    private int statPointsToAllocate; // amount of points player can put on character creation

    public string PlayerName { get => playerName; set => playerName = value; }
    public int PlayerLevel { get => playerLevel; set => playerLevel = value; }
    public BaseCharacterClass PlayerClass { get => playerClass; set => playerClass = value; }
    public int Stamina { get => stamina; set => stamina = value; }
    public int Endurance { get => endurance; set => endurance = value; }
    public int Intellect { get => intellect; set => intellect = value; }
    public int Strength { get => strength; set => strength = value; }
    public int Overpower { get => overpower; set => overpower = value; }
    public int Luck { get => luck; set => luck = value; }
    public int Mastery { get => mastery; set => mastery = value; }
    public int Charisma { get => charisma; set => charisma = value; }

    public int CurrentXP { get => currentXP; set => currentXP = value; }
    public int RequiredXP { get => requiredXP; set => requiredXP = value; }
    public int Gold { get => gold; set => gold = value; }
    public int StatPointsToAllocate { get => statPointsToAllocate; set => statPointsToAllocate = value; }

   }


