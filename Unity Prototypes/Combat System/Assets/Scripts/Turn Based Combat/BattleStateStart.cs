using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BattleStateStart : MonoBehaviour
{
    private BasePlayer newEnemy = new BasePlayer();
    private StatCalculations statCalculations = new StatCalculations();
    private BaseCharacterClass[] classTypes = new BaseCharacterClass[] { new BaseMageClass(), new BaseArcherClass(), new BaseWarriorClass(), new BaseRogueClass() };
    private string[] enemyNames = new string [4] { "Deadly Enemy", "Fierce Enemy", "Subtle Enemy", "Powerful Enemy" };


    private int playerStamina;
    private int playerEndurance;
    private int playerHealth;
    private int playerEnergy;

    public void PrepareBattle()
    {
        CreateNewEnemy();
        DeterminePlayerVitals();
        ChooseWhoGoesFirst();

    }

    private void DeterminePlayerVitals()
    {
        playerStamina = statCalculations.CalculateStat(GameInformation.Stamina, StatCalculations.StatType.STAMINA, GameInformation.PlayerLevel);
        playerEndurance = statCalculations.CalculateStat(GameInformation.Endurance, StatCalculations.StatType.ENDURANCE, GameInformation.PlayerLevel);
        playerHealth = statCalculations.CalculateHealth(playerStamina, GameInformation.PlayerLevel);
        playerEnergy = statCalculations.CalculatePlayerEnergy(playerEndurance, GameInformation.PlayerLevel);

        GameInformation.PlayerHealth = playerHealth;
        GameInformation.PlayerEnergy = playerEnergy;
    }

    private void CreateNewEnemy()
    {
        newEnemy.PlayerName = enemyNames[Random.Range(0, enemyNames.Length)];
        newEnemy.PlayerLevel = Random.Range(GameInformation.PlayerLevel - 2, GameInformation.PlayerLevel + 2);
        newEnemy.PlayerClass = classTypes[Random.Range(0, classTypes.Length)];
        newEnemy.Stamina = statCalculations.CalculateStat(newEnemy.Stamina, StatCalculations.StatType.STAMINA, newEnemy.PlayerLevel);
        newEnemy.Endurance = statCalculations.CalculateStat(newEnemy.Endurance, StatCalculations.StatType.ENDURANCE, newEnemy.PlayerLevel);
        newEnemy.Intellect = statCalculations.CalculateStat(newEnemy.Intellect, StatCalculations.StatType.INTELLECT, newEnemy.PlayerLevel);
        newEnemy.Overpower = statCalculations.CalculateStat(newEnemy.Overpower, StatCalculations.StatType.OVERPOWER, newEnemy.PlayerLevel);
        newEnemy.Luck = statCalculations.CalculateStat(newEnemy.Luck, StatCalculations.StatType.LUCK, newEnemy.PlayerLevel);
        newEnemy.Mastery = statCalculations.CalculateStat(newEnemy.Mastery, StatCalculations.StatType.MASTERY, newEnemy.PlayerLevel);
        newEnemy.Charisma = statCalculations.CalculateStat(newEnemy.Charisma, StatCalculations.StatType.CHARISMA, newEnemy.PlayerLevel);
    }

    private void ChooseWhoGoesFirst()
    {
        if (GameInformation.Luck >= newEnemy.Luck)
        {
            TurnBaseCombatStateMachine.currentState = TurnBaseCombatStateMachine.BattleStates.PLAYERCHOICE;
        }
        else if (GameInformation.Luck < newEnemy.Luck)
        {
            TurnBaseCombatStateMachine.currentState = TurnBaseCombatStateMachine.BattleStates.ENEMYCHOICE;
        }       
    }
}
