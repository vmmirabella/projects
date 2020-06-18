using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BaseCharacterClass
{
    //string descriptors
    private string className;
    private string classDescription;

    //stats - all characters will have the exact same starting stats then it differs based on race and classes
    private int stamina = 12;
    private int endurance =10;
    private int strength = 8;
    private int intellect =8;
    private int overpower = 10;
    private int luck = 10;
    private int mastery = 10;
    private int charisma = 10;

    private List<BaseAbility> playerAbilties = new List<BaseAbility>();

    public enum CharacterClasses
    {
        MAGE,
        ARCHER,
        WARRIOR,
        ROGUE
    }


    public enum MainStatBonuses
    {
        STAMINA,
        ENDURANCE,
        STRENGTH,
        INTELLECT
    }

    public enum SecondStatBonuses
    {
        STAMINA,
        ENDURANCE,
        STRENGTH,
        INTELLECT

    }

    public enum BonusStatBonuses
    {
        LUCK,
        OVERPOWER,
        MASTERY,
        CHARISMA
    }

    public MainStatBonuses MainStat { get; set; }
    public SecondStatBonuses SecondMainStat { get; set; }
    public BonusStatBonuses BonusStat { get; set; }

    public CharacterClasses CharacterClass { get; set; }
          
    //string descriptors - set + get
    public string ClassName { get => className; set => className = value; }
    public string ClassDescription { get => classDescription; set => classDescription = value; }

    //stats - set + get
    public int Stamina { get => stamina; set => stamina = value; }
    public int Endurance { get => endurance; set => endurance = value; }
    public int Strength { get => strength; set => strength = value; }
    public int Intellect { get => intellect; set => intellect = value; }
    public int Overpower { get => overpower; set => overpower = value; }
    public int Luck { get => luck; set => luck = value; }
    public int Mastery { get => mastery; set => mastery = value; }
    public int Charisma { get => charisma; set => charisma = value; }
    public List<BaseAbility> PlayerAbilties { get => playerAbilties; set => playerAbilties = value; }
}
