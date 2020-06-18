package btp600.a3.vmmirabella;

/**
 * Signifies what a Card looks like. Each card has a rank and suit.
 */
public class Card implements Comparable<Card>{
    public enum Suit { DIAMONDS, CLUBS, HEARTS, SPADES }
    private int rank;
    private Suit suit;

    //constructor that creates a card, assigning the rank and suit.
    public Card(int rank, Suit suit) {

        this.rank = rank;
        this.suit= suit;
    }

    //compare one card to another card. Used to sort a player's hand based on rank than suit
    @Override
    public int compareTo(Card c) {
        int cv = c.getRank();
        if (rank != cv) {
            return rank - cv;
        }
        else {
            return suit.compareTo(c.getSuit());
        }
    }

    @Override
    public boolean equals(Object o) { //// TODO: 4/12/2016 added 
        if(!(o instanceof Card))
            return false;
        if(o == this)
            return true;

        Card c = (Card) o;
        return (c.getRank() == rank && c.getSuit() == suit);
    }

    //return the suit of the card
    public Suit getSuit()
    {
        return suit;
    }

    //return the rank of the card
    public int getRank(){ return rank;}

    //display the suit and rank of the card
    public String toString() { return ""+ rank + suit;  }

    public void setSuit(Suit s) {suit=s;} //todo added

}
