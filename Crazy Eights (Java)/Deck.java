package btp600.A2;

import java.util.ArrayList;
import java.util.Collections;
import java.util.List;

/**
 * Contains a list of cards to be used in the game. Players will draw from the deck.
 */
public class Deck {
    private List<Card> cards;

    public Deck() {
        cards = new ArrayList<Card>();
    }

    /* Populates deck of 52 cards
     */
    public void initializeFullDeck() {

        Card.Suit[] suits = Card.Suit.values();

        for (int i=1; i<=13; i++) {
            for (int j=0; j<4; j++) {
                Card c = new Card(i, suits[j]);
                cards.add(c);
            }
        }
        shuffle();
    }

    /* Returns if deck is empty
     */
    public boolean isEmpty() {
        return cards.isEmpty();
    }

    /* Draw a card (remove) from the deck
     */
    public Card drawCard() {
        if(!cards.isEmpty()) {
            return cards.remove(0);
        }
        else {
            return null;
        }
    }

    /* Add card to deck
     */
    public void insertCard(Card c) {
        cards.add(c);
    }

    /* Shuffle cards in deck
     */
    public void shuffle() {
        Collections.shuffle(cards);
    }
}
