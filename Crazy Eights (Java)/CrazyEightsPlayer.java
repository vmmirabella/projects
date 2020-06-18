package btp600.A2;

/**
 * Created by VM on 4/11/2016.
 */
public class CrazyEightsPlayer extends Player {

    //method that calls the super constructor of Player to assign the player's name, which is passed in as a parameter
    public CrazyEightsPlayer (String name) {super(name);}

    /*This method takes in Rules, Deck and Pile objects which are used to determine if a player is able to play a card.
    * Currently this method will check whether a player is able to make a move based on the Rules. If a player is able to make a move based
    * on the current cards in their hand then this method will return true. If there is no valid move and the player has already drawn 3 cards from
    * Deck then false is returned.
    * */
    @Override
    public boolean takeTurn(Rules r, Deck d, Pile p) {
        Card pileCard= p.topOfPile();
        int drawcounter=0;
        boolean hasMove=false;

        System.out.println("\n==== Your turn -> " + getName());

        int handIndex;
        for (handIndex = 0; handIndex < hand.getNumCards(); handIndex++) {
            if (r.isValid(hand.getCard(handIndex), pileCard))
                return true;
            else
                hasMove=true;
        }

        while (hasMove) {
            if(drawcounter>0) {
                if (r.isValid(hand.getCard(handIndex + drawcounter - 1), pileCard))
                    return true;
            }

            if (drawcounter >= 3) {
                System.out.println("--No moves are available and you have reached your draw limit(3). Your turn is passed");
                return false;
            }
            else if (!d.isEmpty()) {
                System.out.println("++No moves are available, drawing you a card");
                drawCard(d);
                drawcounter++;
            }
            else{
                System.out.println("--No moves are available and Deck is empty. Your turn is passed");
                return false;
            }                
        }
        return false;
    }

    /*This method takes in a Card object (the card a player going to play) and a Pile object. This method will add the card the player
    is playing to pile, if successful it will return true, if not successful it will return false.
    * */
    public boolean addToPile(Card card, Pile p) //// TODO: 4/11/2016 added pile to parameter 
    {
        if (card !=null)
        {
             p.getCards().add(card);   
            return true;
        }
        return false;
    }


}
