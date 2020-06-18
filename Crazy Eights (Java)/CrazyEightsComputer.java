package btp600.A2;

/**
 * Created by VM on 4/11/2016.
 */
public class CrazyEightsComputer extends CrazyEightsPlayer{

    //method that calls the super constructor to assign the player's name, which is passed in as a parameter
    public CrazyEightsComputer(String name) {
        super(name);
    }

    /*Method that determines how a computer player will take their turn. This method takes in Rules, Deck and Pile objects
    *to determine whether the computer player. This method will return true when completed to signal that this player has finished their turn.
    *Calls the super.TakeTurn (like CrazyEightsHuman) to determine whether or not the computer is able to currently make a move based on their hand.
    * */
    public boolean takeTurn (Rules r, Deck d, Pile p)
    {
        boolean hasMove;
        Card pileCard = p.topOfPile();
        Card.Suit wildSuit = null;

        hasMove=super.takeTurn(r,d,p);
        System.out.println("*Top of pile is: "+ p);
       for(int i=0; i<hand.getNumCards() && hasMove; i++)
            {
                Card tempCard = hand.getCard(i);
                if(r.isValid(tempCard, pileCard))
                {
                    System.out.println(getName() +" plays " +tempCard);
                    if(tempCard.getRank() == 8)
                    {
                        if(hand.getNumCards()==1)
                            wildSuit=tempCard.getSuit();
                        else if (i + 1 < hand.getNumCards())
                            wildSuit = hand.getCard(i +1).getSuit();
                        else
                            wildSuit = hand.getCard(i -1).getSuit();

                        changeSuit(wildSuit, tempCard);
                    }

                    if (wildSuit!=null) {
                        System.out.println(getName() +" changed the suit to " +wildSuit);
                        tempCard.setSuit(wildSuit);
                    }
                    addToPile(playCard(tempCard), p);
                    hasMove=false;

                }
            }

        return true;
    }

    /*Private method that takes in a card suit and Card. This method then changes the suit of the card passed in (tempCard) to the
    * Suit object that is passed in.
    * */
    private void changeSuit(Card.Suit s, Card tempCard)
    {
        for(int i=0; i<hand.getNumCards(); i++)
        {
            if(hand.getCard(i).getRank() == tempCard.getRank() && hand.getCard(i).getSuit() == tempCard.getSuit())
                hand.getCard(i).setSuit(s);
        }
    }
}
