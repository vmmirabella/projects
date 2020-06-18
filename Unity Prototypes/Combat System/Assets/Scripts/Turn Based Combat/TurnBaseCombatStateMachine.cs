using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class TurnBaseCombatStateMachine : MonoBehaviour
{

    private bool hasAddedXP = false;
    private BattleStateStart battleStateStartScript = new BattleStateStart();
    private BattleCalculations battleCalcScript = new BattleCalculations();
    public static BaseAbility playerUsedAbility;
    private BattleStateAddStatusEffects battleStateAddStatusEffectsScript = new BattleStateAddStatusEffects();

    public enum BattleStates
    {
        START,
        PLAYERCHOICE,
        ENEMYCHOICE,
        CALCDAMAGE,
        ADDSTATUSEFFECTS,
        LOSE,
        WIN
    }

    public static BattleStates currentState;

    // Start is called before the first frame update
    void Start()
    {
        hasAddedXP = false;
        currentState = BattleStates.START;
    }

    // Update is called once per frame
    void Update()
    {
        Debug.Log(currentState);

        switch (currentState)
        {
            case (BattleStates.START):
                //create enemy and start the battle
                battleStateStartScript.PrepareBattle();
                break;
            case (BattleStates.PLAYERCHOICE):              
                break;
            case (BattleStates.ENEMYCHOICE):
                break;
            case (BattleStates.CALCDAMAGE): // calculate damage done by the player, look for exisiting status effects and add that damage
                battleCalcScript.CalculateUsedPlayerAbilityDamage(playerUsedAbility);
                break;
            case (BattleStates.ADDSTATUSEFFECTS): // try to add a status effect if it exists
                battleStateAddStatusEffectsScript.CheckAbilityForStatusEffects(playerUsedAbility);
                break;
            case (BattleStates.LOSE):
                break;
            case (BattleStates.WIN):
                if (!hasAddedXP) { 
                    IncreaseExperience.AddExperience();
                    hasAddedXP = true;
                }
                break;
        }             
    }

    void OnGUI()
    {
        if (GUILayout.Button("NEXT STATE"))
        {
            if (currentState == BattleStates.START)
            {
                currentState = BattleStates.PLAYERCHOICE;
            }
            else if (currentState == BattleStates.PLAYERCHOICE)
            {
                currentState = BattleStates.LOSE;
            }
            else if (currentState == BattleStates.LOSE)
            {
                currentState = BattleStates.WIN;
            }
            else if (currentState == BattleStates.WIN)
            {
                currentState = BattleStates.START;
            }
        }
    }
}
