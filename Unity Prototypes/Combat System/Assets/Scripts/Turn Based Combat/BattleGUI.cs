using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BattleGUI : MonoBehaviour
{
    private string playerName;
    private int playerLevel;
    private int playerHealth;
    private int playerEnergy;




    // Start is called before the first frame update
    void Start()
    {
        playerName = GameInformation.PlayerName;
        playerLevel = GameInformation.PlayerLevel;
        
    }

    // Update is called once per frame
    void Update()
    {
        
    }

    void OnGUI()
    {
        if (TurnBaseCombatStateMachine.currentState == TurnBaseCombatStateMachine.BattleStates.PLAYERCHOICE)
        {
            DisplayPlayersChoice();

        }
    }

    private void DisplayPlayersChoice()
    {
       if( GUI.Button(new Rect(Screen.width - 250, Screen.height - 50, 75, 30), GameInformation.playerMoveOne.AbilityName))
        {
            TurnBaseCombatStateMachine.playerUsedAbility = GameInformation.playerMoveOne;
            TurnBaseCombatStateMachine.currentState = TurnBaseCombatStateMachine.BattleStates.ADDSTATUSEFFECTS;
        }
        if (GUI.Button(new Rect(Screen.width - 150, Screen.height - 50, 75, 30), GameInformation.playerMoveTwo.AbilityName))
        {
            TurnBaseCombatStateMachine.playerUsedAbility = GameInformation.playerMoveTwo;
            TurnBaseCombatStateMachine.currentState = TurnBaseCombatStateMachine.BattleStates.ADDSTATUSEFFECTS;
        }
    }
}
