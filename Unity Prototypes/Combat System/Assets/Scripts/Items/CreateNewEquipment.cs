using System.Collections;
using System.Collections.Generic;
using UnityEngine;

public class CreateNewEquipment : MonoBehaviour
{
    private BaseEquipment newEquipment;
    private string[] itemNames = new string[4] { "Common", "Great", "Amazing", "Insane" };
    private string[] itemDescription = new string [2]{"New cool item","A not-so cool item" };


    // Start is called before the first frame update
    void Start()
    {
        CreateEquipment();
        Debug.Log(newEquipment.ItemName);
        Debug.Log(newEquipment.ItemDescription);
        Debug.Log(newEquipment.ItemID.ToString());
        Debug.Log(newEquipment.EquipmentType.ToString());
        Debug.Log(newEquipment.Stamina.ToString());
        Debug.Log(newEquipment.Endurance.ToString());
    }

    private void CreateEquipment()
    {
        newEquipment = new BaseEquipment();
        newEquipment.ItemName = itemNames[Random.Range(0, 3)] + " Item";
        newEquipment.ItemID = Random.Range(1, 101);
        newEquipment.ItemDescription = itemDescription[Random.Range(0, itemDescription.Length)];
        //stats
        newEquipment.Stamina = Random.Range(1, 11);
        newEquipment.Endurance = Random.Range(1, 11);
        newEquipment.Intellect = Random.Range(1, 11);
        newEquipment.Strength = Random.Range(1, 11);

        ChooseItemType();
    }

    private void ChooseItemType()
    {
        System.Array equipments = System.Enum.GetValues(typeof(BaseEquipment.EquipmentTypes)); // create array from previous enum of equipment types
        newEquipment.EquipmentType = (BaseEquipment.EquipmentTypes)equipments.GetValue(Random.Range(0, equipments.Length)); // gets a random equipment type based on the enum
    }


   
}
