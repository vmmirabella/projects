using System.Collections;
using System.Collections.Generic;
using UnityEngine;
using System;

public class Inventory : MonoBehaviour
{
    [SerializeField] List<Item> items;
    [SerializeField] Transform itemsParent;
    [SerializeField] ItemSlot[] itemSlots;

    public event Action<Item> OnItemRightClickedEvent;

    private void Awake()
    {
        for (int i=0; i<itemSlots.Length; i++)
        {
            itemSlots[i].OnRightClickEvent += OnItemRightClickedEvent;
        }
    }


    private void OnValidate()
    {
        if (itemsParent != null)
        {
            itemSlots = itemsParent.GetComponentsInChildren<ItemSlot>();
        }
        RefreshUI(); // update even when not in playmode
    }

    //called everytime a change has been made to the inventory
    private void RefreshUI()
    {
        int i = 0;
        //every item will be assigned to an item slot
        for(; i<items.Count && i<itemSlots.Length; i++)
        {
            itemSlots[i].Item = items[i];

        }
        //any slot that doesn't contain an item is set to 'null'
        for(; i<itemSlots.Length; i++)
        {
            itemSlots[i].Item = null;
        }
    }

    //add an item to inventory
    public bool AddItem(Item item)
    {
        if (IsFull())
            return false;

        items.Add(item);
        RefreshUI();
        return true;
    }

    public bool RemoveItem(Item item)
    {
        if (items.Remove(item))
        {
            RefreshUI();
            return true;
        }
        return false;
    }

    //check if the inventory is full
    public bool IsFull()
    {
        return items.Count >= itemSlots.Length;
    }
}
