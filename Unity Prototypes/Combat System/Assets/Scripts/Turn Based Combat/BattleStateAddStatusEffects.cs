using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BattleStateAddStatusEffects 
{
    public void CheckAbilityForStatusEffects(BaseAbility usedAbility)
    {
        for (int i=0; i<usedAbility.AbilityStatusEffects.Count; i++)
        {
            switch (usedAbility.AbilityStatusEffects[i].StatusEffectName)
            {
                case ("Burn"):
                    TurnBaseCombatStateMachine.currentState = TurnBaseCombatStateMachine.BattleStates.CALCDAMAGE;
                    break;
            }
        }
        
    }
}
