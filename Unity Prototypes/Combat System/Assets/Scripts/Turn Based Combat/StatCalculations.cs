using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class StatCalculations 
{
    private float enemyStaminaModifier = 0.25f;
    private float enemyEnduranceModifier = 0.25f;
    private float enemyIntellectModifier = 0.2f;
    private float enemyStrengthModifier = 0.2f;
    private float enemyOverpowerModifier = 0.1f;
    private float enemyLuckModifier = 0.1f;
    private float enemyMasteryModifier = 0.1f;
    private float enemyCharismaModifier = 0.1f;

    private readonly float playerStaminaModifier = 0.3f;
    private readonly float playerEnduranceModifier = 0.3f;


    public enum StatType
    {
        STAMINA,
        ENDURANCE,
        INTELLECT,
        STRENGTH,
        OVERPOWER,
        LUCK,
        MASTERY,
        CHARISMA
    }

    public int CalculateStat (int statVal, StatType statType, int level)
    {
        float modifier;

        if (statType == StatType.STAMINA)
        {
            modifier = enemyStaminaModifier;
            return (statVal + (int)((statVal * modifier) * level));
        }
        if (statType == StatType.ENDURANCE)
        {
            modifier = enemyEnduranceModifier;
            return (statVal + (int)((statVal * modifier) * level));
        }
        if (statType == StatType.INTELLECT)
        {
            modifier = enemyIntellectModifier;
            return (statVal + (int)((statVal * modifier) * level));
        }
        if (statType == StatType.STRENGTH)
        {
            modifier = enemyStrengthModifier;
            return (statVal + (int)((statVal * modifier) * level));
        }
        if (statType == StatType.OVERPOWER)
        {
            modifier = enemyOverpowerModifier;
            return (statVal + (int)((statVal * modifier) * level));
        }
        if (statType == StatType.LUCK)
        {
            modifier = enemyLuckModifier;
            return (statVal + (int)((statVal * modifier) * level));
        }
        if (statType == StatType.MASTERY)
        {
            modifier = enemyMasteryModifier;
            return (statVal + (int)((statVal * modifier) * level));
        }
        if (statType == StatType.CHARISMA)
        {
            modifier = enemyCharismaModifier;
            return (statVal + (int)((statVal * modifier) * level));
        }
        return 0;
    }

   public int CalculateHealth(int statValue, int level)
    {
        return (statValue + (int)((statValue * playerStaminaModifier) * level)) * 100;
    }

    public int CalculatePlayerEnergy(int statValue, int level)
    {
        return (statValue + (int)((statValue * playerEnduranceModifier) * level)) * 50;
    }

    public float FindPlayerMainStatWithMainStatModifier()
    {
        float mainStatModifier = 0.5f;

        if (GameInformation.PlayerClass.MainStat == BaseCharacterClass.MainStatBonuses.INTELLECT)
        {
            return GameInformation.Intellect * mainStatModifier;
        }
        return 0;
    }



}
