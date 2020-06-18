using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class CreateNewPotion : MonoBehaviour
{
    private BasePotion newPotion;

    // Start is called before the first frame update
    void Start()
    {
        CreatePotion();
        Debug.Log(newPotion.ItemName);
        Debug.Log(newPotion.ItemDescription);
        Debug.Log(newPotion.ItemID.ToString());
        Debug.Log(newPotion.PotionType.ToString());
    }

    private void CreatePotion()
    {
        newPotion = new BasePotion();

        newPotion.ItemName = "Potion";
        newPotion.ItemDescription = "A Potion";
        newPotion.ItemID = Random.Range(1, 101);
        ChoosePotionType();
    }

    private void ChoosePotionType()
    {
        System.Array potions = System.Enum.GetValues(typeof(BasePotion.PotionTypes)); // create array from previous enum of potion types
        newPotion.PotionType = (BasePotion.PotionTypes)potions.GetValue(Random.Range(0, potions.Length)); // gets a random array index 
    }
    
}
