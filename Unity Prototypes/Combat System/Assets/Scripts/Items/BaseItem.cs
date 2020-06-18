using System.Collections;
using System.Collections.Generic;
using UnityEngine;

//***** LOOK INTO SCRIPTABLE OBJECTS INSTEAD OF CREATING CLASSES W/ SUBCLASSES FOR EACH TYPE *****

// lowest level of item. All items in the game will at least have these properties
[System.Serializable]
public class BaseItem 
{
    //item descriptors
    private string itemName;
    private string itemDescription;
    private int itemID;

    //enum that holds all the different item types in the game
    public enum ItemTypes
    {
        EQUIPMENT,
        WEAPON,
        SCROLL,
        POTION,
        CHEST
    }

    private ItemTypes itemType;

    public BaseItem() {}

    public BaseItem(Dictionary<string, string> itemsDictionary)
    {
        itemName = itemsDictionary["ItemName"];
        itemID = int.Parse(itemsDictionary["ItemID"]);
        ItemType = (ItemTypes) System.Enum.Parse (typeof(BaseItem.ItemTypes), itemsDictionary["ItemTypes"]);
    }
    public string ItemName { get => itemName; set => itemName = value; }
    public string ItemDescription { get => itemDescription; set => itemDescription = value; }
    public int ItemID { get => itemID; set => itemID = value; }
    public ItemTypes ItemType { get => itemType; set => itemType = value; }
}
