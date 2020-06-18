using System.Collections;
using System.Collections.Generic;
using UnityEngine;

[System.Serializable]
public class BaseEquipment: BaseStatItem
{
    public enum EquipmentTypes
    {
        HEAD,
        SHOULDERS,
        CHEST,
        LEGS,
        FEET,
        NECK,
        EARRINGS,
        RING
    }

    private EquipmentTypes equipmentTypes;
    private int spellEffectID;
  
    public EquipmentTypes EquipmentType { get => equipmentTypes; set => equipmentTypes = value; }
    public int SpellEffectID { get => spellEffectID; set => spellEffectID = value; }
}

