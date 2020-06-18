using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class BasePotion : BaseStatItem
{
   public enum PotionTypes
    {
        HEALTH,
        ENERGY,
        STRENGTH,
        INTELLECT,
        STAMINA,
        ENDURANCE,
        SPEED,
        OVERPOWER,
        MASTERY,
        LUCK,
        CHARISMA
        
    }

    private PotionTypes potionType;
    private int spellEffectID;

    public PotionTypes PotionType { get => potionType; set => potionType = value; }
    public int SpellEffectID { get => spellEffectID; set => spellEffectID = value; }
}
