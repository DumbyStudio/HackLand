class Player
{
    element;

    name;
    x;
    y;

    attributs;

    arme;
    inventaire;

    constructor(element, name, x, y)
    {
        this.element = element;
        this.name = name;
        this.x = x;
        this.y = y;
        let attributs = [];
        attributs['force'] = 0;
        attributs['magie'] = 0;
        attributs['defense'] = 0;
        attributs['vie'] = 0;
        attributs['agilite'] = 0;
        attributs['charisme'] = 0;
        attributs['chance'] = 0;
        attributs['attspe'] = 0;
        this.arme = "une arme.";
        this.inventaire = "des trucs.";
    }

    /*constructor(name, x, y, attributs, arme, inventaire)
    {
        this.name = name;
        this.x = x;
        this.y = y;
        this.attributs = attributs;
        this.arme = arme;
        this.inventaire = inventaire;
    }*/

    move(x,y)
    {
        this.x = x;
        this.y = y;
        this.element.css( { left: x, top: y } );
    }

    setAttribut(nomAttribut, valeur)
    {
        attributs[nomAttribut] = valeur;
    }
}

class Npc
{
    element;

    name;
    x;
    y;

    hidden;

    type;

    constructor(element, name, x, y, hidden, type)
    {
        this.element = element;
        this.name = name;
        this.x = x;
        this.y = y;
        this.hidden = hidden;
        this.type = type;
    }

    setHidden(hidden)
    {
        this.hidden = hidden;
    }

    show()
    {
        this.hidden = false;
    }

    hide()
    {
        this.hidden = true;
    }

    getCssTypeClass()
    {
        cssClass;
        switch(type)
        {
            default:
            case 'pacifist':
                cssClass = "PacifistNpc";
                break;
            case 'neutral':
                cssClass = "NeutralNpc"
                break;
            case 'evil':
                cssClass = "EvilNpc";
                break;
        }
        return cssClass;
    }
}